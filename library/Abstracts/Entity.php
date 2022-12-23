<?php

namespace Library\Abstracts;

use ArrayAccess;

abstract class Entity implements ArrayAccess
{
    protected array $erreurs = [];
    protected int $id;

    public function __construct(array $donnees = [])
    {
        if (!empty($donnees)) {
            $this->hydrate($donnees);
        }
    }

    public function hydrate(array $donnees)
    {
        foreach ($donnees as $attribut => $valeur) {
            $methode = 'set' . ucfirst($attribut);
            if (is_callable(array($this, $methode))) {
                $this->$methode($valeur);
            }
        }
    }

    public function isNew(): bool
    {
        return empty($this->id);
    }

    public function erreurs(): array
    {
        return $this->erreurs;
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
}