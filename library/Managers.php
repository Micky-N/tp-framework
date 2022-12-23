<?php

namespace Library;

use Library\Abstracts\Manager;
use PDO;

class Managers
{
    /** @var Manager[] $managers  */
    protected array $managers = [];

    public function __construct(protected ?string $api, protected ?PDO $dao)
    {
    }

    public function getManagerOf(string $module): Manager
    {
        if (empty($module)) {
            throw new \InvalidArgumentException('Le module spécifié est invalide');
        }
        if (!isset($this->managers[$module])) {
            $manager = '\\Library\\Models\\' . $module . 'Manager' . $this->api;
            $this->managers[$module] = new $manager($this->dao);
        }
        return $this->managers[$module];
    }
}