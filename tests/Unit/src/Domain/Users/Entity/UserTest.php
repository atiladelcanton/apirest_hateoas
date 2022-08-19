<?php

namespace Tests\Unit\src\Domain\Users\Entity;

use App\Domain\Users\Entity\User;
use App\Shared\Exception\InvalidArgumentException;
use DateTime;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_should_not_accept_null_params()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Review the information has been sent");
        $this->expectExceptionCode(422);
        new User('', '', '', new DateTime('now'));
    }

    public function test_it_must_return_the_entered_values()
    {
        $id = uniqid();
        $createdAt = new DateTime('now');
        $user = new User($id, 'Jose', 'jose@email.com', $createdAt);

        $this->assertEquals($id, $user->getId());
        $this->assertEquals('Jose', $user->getName());
        $this->assertEquals('jose@email.com', $user->getEmail());
        $this->assertEquals($createdAt->format('d/m/Y'), $user->getCreatedAt());
    }
    public function test_should_validate_name_is_not_null()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Review the information has been sent");
        $this->expectExceptionCode(422);

        new User('123', '', 'email@email.com', new DateTime('now'));
    }
    public function test_should_validate_email_is_not_null()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Review the information has been sent");
        $this->expectExceptionCode(422);

        new User('123', 'Jose', '', new DateTime('now'));
    }
}