<?php

namespace Library\Abstracts;

abstract class Field
{
    protected string $errorMessage;
    protected string $label;
    protected string $name;
    protected string $value;
    /** @var Validator[] $validators */
    protected array $validators = [];

    public function __construct(array $options = array())
    {
        if (!empty($options)) {
            $this->hydrate($options);
        }
    }

    public function hydrate($options): void
    {
        foreach ($options as $type => $value) {
            $method = 'set' . ucfirst($type);
            if (is_callable(array($this, $method))) {
                $this->$method($value);
            }
        }
    }

    abstract public function buildWidget();

    public function isValid(): bool
    {
        foreach ($this->validators as $validator) {
            if (!$validator->isValid($this->value)) {
                $this->errorMessage = $validator->errorMessage();
                return false;
            }
        }
        return true;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return Validator[]
     */
    public function validators(): array
    {
        return $this->validators;
    }

    public function setValidators(array $validators): void
    {
        foreach ($validators as $validator) {
            if ($validator instanceof Validator && !in_array($validator, $this->validators)) {
                $this->validators[] = $validator;
            }
        }
    }
}