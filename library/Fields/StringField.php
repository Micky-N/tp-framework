<?php

namespace Library\Fields;

class StringField extends \Library\Abstracts\Field
{

    protected int $maxLength;

    public function buildWidget(): string
    {
        $widget = '';
        if (!empty($this->errorMessage)) {
            $widget .= $this->errorMessage . '<br />';
        }
        $widget .= '<label for="' . $this->name . '">' . $this->label . '</label><input type="text"name="' . $this->name . '"';
        if (!empty($this->value)) {
            $widget .= ' value="' . htmlspecialchars($this->value) . '"';
        }
        if (!empty($this->maxLength)) {
            $widget .= ' maxlength="' . $this->maxLength . '"';
        }
        return $widget . ' />';
    }

    public function setMaxLength(int $maxLength)
    {
        if ($maxLength > 0) {
            $this->maxLength = $maxLength;
        } else {
            throw new \RuntimeException('La longueur maximale doit être un nombre supérieur à 0');
        }
    }
}