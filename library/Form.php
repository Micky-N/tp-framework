<?php

namespace Library;

use Library\Abstracts\Entity;
use Library\Abstracts\Field;

class Form
{
    protected Entity $entity;

    /** @var Field[] $fields */
    protected array $fields;

    public function __construct(Entity $entity)
    {
        $this->setEntity($entity);
    }

    public function setEntity(Entity $entity): void
    {
        $this->entity = $entity;
    }

    public function add(Field $field): static
    {
        $attr = $field->name(); // On récupère le nom du champ.
        $field->setValue($this->entity->$attr()); // On assigne la valeur correspondante au champ.
        $this->fields[] = $field; // On ajoute le champ passé en argument à la liste des champs.
        return $this;
    }

    public function addSubmit(Field $field): static
    {
        $this->fields[] = $field; // On ajoute le champ passé en argument à la liste des champs.
        return $this;
    }

    public function createView(): string
    {
        $view = '';
        foreach ($this->fields as $field) {
            $view .= $field->buildWidget() . '<br/>';
        }
        return $view;
    }

    public function isValid(): bool
    {
        $valid = true;
        // On vérifie que tous les champs sont valides.
        foreach ($this->fields as $field) {
            if (!$field->isValid()) {
                $valid = false;
            }
        }
        return $valid;
    }

    public function entity(): Entity
    {
        return $this->entity;
    }
}