<?php

namespace App\Domain\Users\Entity;

use App\Shared\Exception\InvalidArgumentException;
use App\Shared\Validations\ErrorMessage;
use DateTimeInterface;

class User
{
    protected array $validationErrors;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public DateTimeInterface $createdAt
    ) {
        $this->validationErrors = [];
        $this->isValid();
    }

    /**
     * @throws InvalidArgumentException
     */
    private function isValid(): void
    {
        $this->nameIsValid();
        $this->emailIsValid();

        if (!empty($this->validationErrors)) {
            throw new InvalidArgumentException(
                "Review the information has been sent", 422, null, $this->validationErrors
            );
        }
    }


    private function nameIsValid(): void
    {
        if (empty($this->name)) {
            $this->validationErrors[] = ErrorMessage::handle("name", "Name is required");
        }
    }


    private function emailIsValid(): void
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->validationErrors[] = ErrorMessage::handle("email", "E-mail is required");
        }
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt->format('d/m/Y');
    }

}