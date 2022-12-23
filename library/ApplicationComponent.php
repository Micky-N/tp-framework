<?php

namespace Library;

class ApplicationComponent
{
    public function __construct(protected Application $app)
    {
    }

    public function app(): Application
    {
        return $this->app;
    }
}