<?php

namespace Library;

class Config extends ApplicationComponent
{
    protected array $vars = [];

    public function get(string|int $var)
    {
        if (!$this->vars) {
            $xml = new \DOMDocument;
            $xml->load(dirname(__DIR__). '/app/' . $this->app->name() . '/Config/app.xml');
            $elements = $xml->getElementsByTagName('define');
            foreach ($elements as $element) {
                $this->vars[$element->getAttribute('var')] = $element->getAttribute('value');
            }
        }
        if (isset($this->vars[$var])) {
            return $this->vars[$var];
        }
        return null;
    }
}