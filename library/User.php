<?php

namespace Library;

namespace Library;


use Library\Abstracts\Entity;

class User extends ApplicationComponent
{
    public function __construct(protected readonly Application $app)
    {
        if(session_status() === PHP_SESSION_NONE || session_status() !== PHP_SESSION_ACTIVE){
            session_start();
        }
    }

    public function getAttribute($attr)
    {
        return $_SESSION[$attr] ?? null;
    }

    public function getFlash(string $name)
    {
        $flashes = $_SESSION['flash'];
        $flash = $flashes[$name];
        unset($flashes[$name]);
        $_SESSION['flash'] = $flashes;
        return $flash;
    }

    public function hasFlash(string $name): bool
    {
        return isset($_SESSION['flash'][$name]);
    }

    public function isAuthenticated(): bool
    {
        return isset($_SESSION['auth']) && $_SESSION['auth'] !== false;
    }

    public function setAttribute(string $attr, mixed $value)
    {
        $_SESSION[$attr] = $value;
    }

    public function setAuthenticated(int|bool $authenticated, string $type = '')
    {
        $_SESSION['auth'] = $authenticated;
        if($authenticated){
            $_SESSION['type'] = $type;
        }else{
            unset($_SESSION['type']);
        }
    }

    public function setFlash(string $name, mixed $value)
    {
        if(empty($_SESSION['flash'])){
            $_SESSION['flash'] = [];
        }
        $_SESSION['flash'][$name] = $value;
    }

    public function getAuthenticate(): array
    {
        return ['auth' => $_SESSION['auth'], 'type' => $_SESSION['type']];
    }
}