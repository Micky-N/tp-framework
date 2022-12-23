<?php

namespace Library\Abstracts;

use Library\Form;

abstract class FormBuilder
{
    protected Form $form;


    public function __construct(Entity $entity)
    {
        $this->setForm(new Form($entity));
    }

    public function setForm(Form $form): void
    {
        $this->form = $form;
    }

    abstract public function build();

    public function form(): Form
    {
        return $this->form;
    }
}