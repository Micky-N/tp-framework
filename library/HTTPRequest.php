<?php

namespace Library;

class HTTPRequest extends ApplicationComponent
{
    public function cookieData($key): mixed
    {
        return $_COOKIE[$key] ?? null;
    }

    public function cookieExists($key): bool
    {
        return isset($_COOKIE[$key]);
    }

    public function getData($key): mixed
    {
        return $_GET[$key] ?? null;
    }

    public function getExists($key): bool
    {
        return isset($_GET[$key]);
    }

    public function method(): mixed
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function postData($key): mixed
    {
        return $_POST[$key] ?? null;
    }

    public function postExists($key): bool
    {
        return isset($_POST[$key]);
    }

    public function requestURI(): mixed
    {
        return $_SERVER['REQUEST_URI'];
    }
}