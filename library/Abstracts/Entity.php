<?php

namespace Library\Abstracts;

use ArrayAccess;

abstract class Entity implements ArrayAccess
{
    protected array $errors = [];
    protected int $id;

    public function __construct(array $donnees = [])
    {
        if (!empty($donnees)) {
            $this->hydrate($donnees);
        }
    }

    public function hydrate(array $data)
    {
        foreach ($data as $name => $value) {
            $methode = 'set' . $this->snakeToPascalCase($name);
            if (is_callable(array($this, $methode))) {
                $this->$methode($value);
            }
        }
    }

    public function isNew(): bool
    {
        return empty($this->id);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = (int)$id;
    }

    public function offsetGet($var): mixed
    {
        if (isset($this->$var) && is_callable(array($this, $var))) {
            return $this->$var();
        }
        return null;
    }

    public function offsetSet($var, mixed $value): void
    {
        $method = 'set' . ucfirst($var);
        if (isset($this->$var) && is_callable(array($this, $method))) {
            $this->$method($value);
        }
    }

    public function offsetExists($var): bool
    {
        return isset($this->$var) && is_callable(array($this, $var));
    }

    public function offsetUnset(mixed $var): void
    {
        throw new \Exception('Impossible de supprimer une quelconque valeur');
    }

    private function snakeToPascalCase(string $word): string
    {
        return str_replace('_', '', ucwords($word, '_'));
    }
}