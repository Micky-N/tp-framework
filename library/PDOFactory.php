<?php

namespace Library;

class PDOFactory
{
    public static function getMysqlConnexion(): \PDO
    {
        $db = new \PDO('mysql:host=localhost;dbname=phpframework', 'root', '');
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $db;
    }
}