<?php

namespace Library\Abstracts;

abstract class Validator
{
    protected string $errorMessage;

    public function __construct($errorMessage)
    {
        $this->setErrorMessage($errorMessage);
    }

    public function setErrorMessage(string $errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }

    abstract public function isValid($value): bool;

    public function errorMessage(): string
    {
        return $this->errorMessage;
    }
}