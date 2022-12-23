<?php

namespace Library\Validators;

class NotNullValidator extends \Library\Abstracts\Validator
{

    public function isValid($value): bool
    {
        return $value != '';
    }
}