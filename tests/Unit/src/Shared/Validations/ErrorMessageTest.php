<?php

namespace Tests\Unit\src\Shared\Validations;

use App\Shared\Validations\ErrorMessage;
use PHPUnit\Framework\TestCase;

class ErrorMessageTest extends TestCase
{
    public function test_should_return_array_with_message()
    {
        $errorMessage = ErrorMessage::handle("name", "Name is Required");

        $this->assertEquals([
            "field" => "name",
            "message" => "Name is Required"
        ], $errorMessage);
    }

    public function test_with_keys_exists_in_array()
    {
        $errorMessage = ErrorMessage::handle("name", "Name is Required");

        $this->assertArrayHasKey('field', $errorMessage);
        $this->assertArrayHasKey('message', $errorMessage);
    }
}