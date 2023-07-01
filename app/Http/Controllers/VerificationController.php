<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTransferObjects\Issuer;
use App\DataTransferObjects\Recipient;
use App\Models\Verification;
use App\Utilities\JsonPathUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller {
    public const MAX_FILE_SIZE_KILOBYTE = 2000;
    public const VERIFICATION_RESULT_SUCCESS = "1";
    public const VERIFICATION_RESULT_FAIL = "0";
    public const INVALID_SIGNATURE = 'invalid_signature';
    public const INVALID_FILE_TYPE = 'invalid_file_type';

    public function verify(Request $request) {
        $request->validate([
            'fileInput' => ["required", "file", "max:" . self::MAX_FILE_SIZE_KILOBYTE],
        ]);

        $content = $request->file('fileInput')->get();

        $contentValidator = Validator::make(['fileContent' => $content], ['fileContent' => ['json']]);

        if ($contentValidator->fails()) {
            $contentValidator->errors()->add("content", 'Invalid JSON file.');
            self::logVerification(Auth::user()->id, $request->file('fileInput')->getClientMimeType(), self::VERIFICATION_RESULT_FAIL, self::INVALID_FILE_TYPE);
            return redirect()->back()->withErrors($contentValidator->errors());
        }
        $content = json_decode($content, true);

        // Condition #1: Check recipient
        $recipient = Recipient::fromJson($content['data']['recipient']);
        $recipientValidator = Validator::make((array) $recipient, Recipient::rules(), Recipient::messages());
        if ($recipientValidator->fails()) {
            self::logVerification(Auth::user()->id, $request->file('fileInput')->getClientMimeType(), self::VERIFICATION_RESULT_FAIL, Recipient::INVALID_RECIPIENT);
            return redirect()->back()->withErrors($recipientValidator->errors());
        }

        // Condition #2: Check issuer
        $issuer = Issuer::fromJson($content['data']['issuer']);
        $issuerValidator = Validator::make(Issuer::toArray($issuer), Issuer::rules(), Issuer::messages());

        if ($issuerValidator->fails()) {
            self::logVerification(Auth::user()->id, $request->file('fileInput')->getClientMimeType(), self::VERIFICATION_RESULT_FAIL, Issuer::INVALID_ISSUER);
            return redirect()->back()->withErrors($issuerValidator->errors());
        }

        // Make sure its valid DNS
        $identityProofEndpoint = "https://dns.google/resolve?name=" . $issuer->identityProof->location . "&type=TXT";
        $response = Http::get($identityProofEndpoint)->body();
        $decoded = json_decode($response, true);
        if ($decoded) {
            if (!array_key_exists('Answer', $decoded) || sizeof($decoded['Answer']) == 0) {
                $issuerValidator->errors()->add("identityProof", Issuer::INVALID_ISSUER);
                self::logVerification(Auth::user()->id, $request->file('fileInput')->getClientMimeType(), self::VERIFICATION_RESULT_FAIL, Issuer::INVALID_ISSUER);
                return redirect()->back()->withErrors($issuerValidator);
            }
        }

        // Condition #3: Check signature
        $paths = JsonPathUtility::findAll($content['data'], ''); // '' means root path, start with root path.
        $computedPathSignatures = [];
        foreach ($paths as $key => $value) {
            $kvp = "{\"{$key}\":\"{$value}\"}";
            array_push($computedPathSignatures, hash('SHA256', $kvp));
        }

        // Extra conditions if needed...


        // echo '<pre>PATH:' . var_export($paths, true) . '</pre>';
        // echo '<pre>COMPUTED PATHS SIGNATURE:' . var_export($computedPathSignatures, true) . '</pre>';
        // echo '<pre>COMPUTED HASH:' . var_export($finalComputedHash, true) . '</pre>';
        // echo '<pre>TARGET HASH:' . var_export($content['signature']['targetHash'], true) . '</pre>';
        sort($computedPathSignatures);
        $finalComputedHash = hash('SHA256', json_encode($computedPathSignatures));
        $hashValidator = Validator::make(
            ['finalComputedHash' => $finalComputedHash, 'targetHash' => $content['signature']['targetHash']],
            ['finalComputedHash' => ['required', 'same:targetHash'], 'targetHash' => ['required']]
        );

        if ($hashValidator->passes()) {
            self::logVerification(Auth::user()->id, $request->file('fileInput')->getClientMimeType(), self::VERIFICATION_RESULT_SUCCESS, "success");
            return redirect()->back()->with('message', 'Verified.');
        } else {
            self::logVerification(Auth::user()->id, $request->file('fileInput')->getClientMimeType(), self::VERIFICATION_RESULT_FAIL, self::INVALID_SIGNATURE);
            $hashValidator->errors()->add("hash", self::INVALID_SIGNATURE);
            return redirect()->back()->withErrors($hashValidator);
        }
    }

    private function logVerification(int $userId, string $fileType, string $result, string $resultDetail): void {
        Verification::create(['user_id' => $userId, 'file_type' => $fileType, 'result' => $result, 'result_detail' => $resultDetail]);
    }
}
