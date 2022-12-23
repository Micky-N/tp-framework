<?php

namespace Library;

use Library\Abstracts\Manager;

class FormHandler
{
    protected Form $form;
    protected Manager $manager;
    protected HttpRequest $request;

    public function __construct(Form $form, Manager $manager, HTTPRequest $request)
    {
        $this->setForm($form);
        $this->setManager($manager);
        $this->setRequest($request);
    }

    public function setForm(Form $form): void
    {
        $this->form = $form;
    }

    public function setManager(Manager $manager): void
    {
        $this->manager = $manager;
    }

    public function setRequest(HTTPRequest $request): void
    {
        $this->request = $request;
    }

    public function process(): bool
    {
        if ($this->request->method() == 'POST' && $this->form->isValid()) {
            $this->manager->save($this->form->entity());
            return true;
        }
        return false;
    }
}