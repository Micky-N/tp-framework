<?php

namespace Library\Validators;

class MaxLengthValidator extends \Library\Abstracts\Validator
{

    protected int $maxLength;

    public function __construct($errorMessage, $maxLength)
    {
        parent::__construct($errorMessage);
        $this->setMaxLength($maxLength);
    }

    /**
     * @param int $maxLength
     * @return void
     */
    public function setMaxLength(int $maxLength): void
    {
        if ($maxLength > 0) {
            $this->maxLength = $maxLength;
        } else {
            throw new \RuntimeException('La longueur maximale doit être un nombre supérieur à 0');
        }
    }

    public function isValid($value): bool
    {
        return strlen($value) <= $this->maxLength;
    }
}