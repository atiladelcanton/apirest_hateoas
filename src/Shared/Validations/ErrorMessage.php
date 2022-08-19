<?php

namespace App\Shared\Validations;

final class ErrorMessage
{
    public static function handle(string $name, string $message): array
    {
        return [
            "field" => $name,
            "message" => $message
        ];
    }

}