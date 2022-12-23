<?php

namespace Library\Abstracts;

abstract class Manager
{
    protected \PDO $dao;

    public function __construct(\PDO $dao)
    {
        $this->dao = $dao;
    }
}