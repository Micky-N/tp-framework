<?php

namespace Library;
class Router
{
    const NO_ROUTE = 1;
    /**
     * @var Route[]
     */
    protected array $routes = [];

    public function addRoute(Route $route): void
    {
        if (!in_array($route, $this->routes)) {
            $this->routes[] = $route;
        }
    }

    public function getRoute($url): Route
    {
        foreach ($this->routes as $route) {
            if (($varsValues = $route->match($url)) !== false) {
                $listVars = [];
                $varsNames = $route->varsNames();
                foreach ($varsValues as $key => $match) {
                    if ($key !== 0) {
                        $listVars[$varsNames[$key - 1]] = $match;
                    }
                }
                $route->setVars($listVars);
                return $route;
            }
        }
        throw new \RuntimeException('Aucune route ne correspond à l\'URL', self::NO_ROUTE);
    }
}