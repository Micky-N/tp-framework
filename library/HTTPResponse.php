<?php

namespace Library;

class HTTPResponse extends ApplicationComponent
{
    protected Page $page;

    public function addHeader($header)
    {
        header($header);
    }

    public function redirect($location): void
    {
        header('Location: ' . $location);
        exit;
    }

    public function redirect404(): void
    {
        $this->page = new Page($this->app);
        $this->page->addVar('title', '404 Error');
        $this->page->setContentFile(dirname(__DIR__).'/errors/404.html');
        $this->addHeader('HTTP/1.0 404 Not Found');
        $this->send();
    }

    public function send(): void
    {
        exit($this->page->getGeneratedPage());
    }

    public function setPage(Page $page): void
    {
        $this->page = $page;
    }

    public function setCookie($name, $value = '', $expire = 0, $path = null, $domain = null, $secure = false, $httpOnly = true): bool
    {
        return setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
    }
}