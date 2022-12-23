<?php

namespace Library\Fields;

class TextField extends \Library\Abstracts\Field
{

    protected int $cols;
    protected int $rows;

    public function buildWidget(): string
    {
        $widget = '';
        if (!empty($this->errorMessage)) {
            $widget .= $this->errorMessage . '<br />';
        }
        $widget .= '<label for="' . $this->name . '">' . $this->label . '</label><textarea name="' . $this->name . '"';
        if (!empty($this->cols)) {
            $widget .= ' cols="' . $this->cols . '"';
        }
        if (!empty($this->rows)) {
            $widget .= ' rows="' . $this->rows . '"';
        }
        $widget .= '>';
        if (!empty($this->value)) {
            $widget .= htmlspecialchars($this->value);
        }
        return $widget . '</textarea>';
    }

    public function setCols(int $cols)
    {
        if ($cols > 0) {
            $this->cols = $cols;
        }
    }

    public function setRows(int $rows)
    {
        if ($rows > 0) {
            $this->rows = $rows;
        }
    }
}