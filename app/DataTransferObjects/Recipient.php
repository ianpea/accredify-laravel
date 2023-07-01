<?php

namespace App\DataTransferObjects;

class Recipient {
    public const INVALID_RECIPIENT = "invalid_recipient";
    public function __construct(
        public string $name,
        public string $email
    ) {
    }

    public static function fromJson($json): Recipient {
        return new Recipient($json['name'], $json['email']);
    }

    public static function rules(): array {
        return [
            'name' => ['required'], //Must be a number and length of value is 8
            'email' => ['required', 'email']
        ];
    }

    public static function messages(): array {
        return [
            'name.required' => self::INVALID_RECIPIENT, //Must be a number and length of value is 8
            'email.required' => self::INVALID_RECIPIENT
        ];
    }
}
