<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\IdentityProof;

class Issuer {
    public const INVALID_ISSUER = "invalid_issuer";
    public function __construct(
        public string $name,
        public IdentityProof $identityProof
    ) {
    }

    public static function fromJson($json): Issuer {
        return new Issuer($json['name'], IdentityProof::fromJson($json['identityProof']));
    }

    public static function toArray(Issuer $issuer): array {
        return (array)json_decode(json_encode($issuer), true);
    }

    public static function rules(): array {
        return [
            'name' => ['required'], //Must be a number and length of value is 8
            'identityProof.key' => ['required'],
            'identityProof.type' => ['required'],
            'identityProof.location' => ['required']
        ];
    }


    public static function messages(): array {
        return [
            'name.required' => self::INVALID_ISSUER, //Must be a number and length of value is 8
            'identityProof.key.required' => self::INVALID_ISSUER,
            'identityProof.type.required' => self::INVALID_ISSUER,
            'identityProof.location.required' => self::INVALID_ISSUER
        ];
    }
}
