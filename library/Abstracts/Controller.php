<?php

namespace Library\Abstracts;

use Library\Application;
use Library\ApplicationComponent;
use Library\Managers;
use Library\Page;
use Library\PDOFactory;

abstract class Controller extends ApplicationComponent
{
    protected string $action = '';
    protected string $module = '';
    protected ?Page $page = null;
    protected string $view = '';
    protected Managers $managers;

    public function __construct(Application $app, $module, $action)
    {
        parent::__construct($app);
        $this->managers = new Managers('PDO', PDOFactory::getMysqlConnexion());
        $this->page = new Page($app);
        $this->setModule($module);
        $this->setAction($action);
        $this->setView($action);
    }

    public function setModule($module)
    {
        if (!is_string($module) || empty($module)) {
            throw new \InvalidArgumentException('Le module doit être une chaine de caractères valide');
        }
        $this->module = $module;
    }

    public function setAction($action)
    {
        if (!is_string($action) || empty($action)) {
            throw new \InvalidArgumentException('L\'action doit être une chaine de caractères valide');
        }
        $this->action = $action;
    }

    public function setView($view)
    {
        if (!is_string($view) || empty($view)) {
            throw new \InvalidArgumentException('La vue doit être une chaine de caractères valide');
        }
        $this->view = $view;
        $this->page->setContentFile(dirname(__DIR__, 2) . '/app/' . $this->app->name() . '/Modules/' . $this->module . '/Views/' . $this->view . '.php');
    }

    public function execute()
    {
        $method = 'execute' . ucfirst($this->action);
        if (!is_callable([$this, $method])) {
            throw new \RuntimeException("L\'action \"$this->action\"n\'est pas définie sur ce module");
        }
        $this->$method($this->app->httpRequest());
    }

    public function page(): ?Page
    {
        return $this->page;
    }
}