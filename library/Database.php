<?php

namespace Library;
use PDO;

class Database
{
    private static ?PDO $_db = null;

    public static function getConnection(): PDO
    {
        if (is_null(self::$_db)) {
            $config = (include 'config.php')['database'];
            $db = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password']);
            $db->query("SET NAMES utf8");
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            self::$_db = $db;
        }
        return self::$_db;
    }
}