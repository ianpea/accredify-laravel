<?php

namespace Tests\Unit;

use App\Utilities\JsonPathUtility;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class JsonPathUtilityTest extends TestCase {
    public function test_utility_find_all_paths_returns_correct_json_path(): void {
        $baseContent = Storage::disk('testing')->get('json_paths_find_all_base.json');

        $resultContent = Storage::disk('testing')->get('json_paths_find_all_result.json');

        // make sure the result of JsonPaths::findAll($baseContent) == $resultContent.
        $finalResult = json_encode(JsonPathUtility::findAll($baseContent, ''));

        $this->assertEquals(json_decode($resultContent), json_decode($finalResult));
    }
}
