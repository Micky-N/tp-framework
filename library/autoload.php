<?php

function chargerClasse($classname): bool
{
    $namespace = str_replace('\\', DIRECTORY_SEPARATOR, $classname);
    $namespace = dirname(__DIR__).DIRECTORY_SEPARATOR.lcfirst($namespace);
    if (!file_exists($namespace.'.php')) {
        return false;
    }
    require $namespace.'.php';
    return true;
}

spl_autoload_register('chargerClasse');