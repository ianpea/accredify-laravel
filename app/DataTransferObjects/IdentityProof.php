<?php

namespace App\DataTransferObjects;

class IdentityProof {
    public function __construct(
        public string $key,
        public string $type,
        public string $location
    ) {
    }

    public static function fromJson($json): IdentityProof {
        return new IdentityProof($json['key'], $json['type'], $json['location']);
    }
}
