<?php

namespace Library\Entities;

use DateTime;
use Exception;

class Customer extends \Library\Abstracts\Entity
{
    const INVALID_EMAIL = 1;
    const INVALID_PASSWORD = 2;
    protected string $email;
    protected string $password;
    protected ?DateTime $createdAt = null;
    protected ?DateTime $updatedAt = null;

    public function isValid(): bool
    {
        return !(empty($this->email) || empty($this->password));
    }

    // SETTERS //
    public function setEmail(string $email): void
    {
        if (empty($email)) {
            $this->errors[] = self::INVALID_EMAIL;
        } else {
            $this->email = $email;
        }
    }

    public function setPassword(string $password): void
    {
        if (empty($password)) {
            $this->errors[] = self::INVALID_PASSWORD;
        } else {
            $this->password = $password;
        }
    }

    /**
     * @param string|DateTime $created_at
     * @return void
     * @throws Exception
     */
    public function setCreatedAt(string|DateTime $created_at): void
    {
        if (is_string($created_at)) {
            $created_at = new DateTime($created_at);
        }
        $this->createdAt = $created_at;
    }

    /**
     * @param string|DateTime $updated_at
     * @return void
     * @throws Exception
     */
    public function setUpdatedAt(string|DateTime $updated_at): void
    {
        if (is_string($updated_at)) {
            $updated_at = new DateTime($updated_at);
        }
        $this->updatedAt = $updated_at;
    }

    // GETTERS //
    public function email(): string
    {
        return $this->email ?? '';
    }

    public function password(): string
    {
        return $this->password ?? '';
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}