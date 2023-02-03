<?php

namespace Library;

class ApplicationComponent
{
    public function __construct(protected readonly Application $app)
    {
    }

    public function app(): Application
    {
        return $this->app;
    }
}