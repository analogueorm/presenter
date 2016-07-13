<?php

namespace Analogue\Presenter;

use Blade;
use Exception;
use Illuminate\Support\ServiceProvider;

class PresentBladeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive("presenteach", function ($expression) {
            $entity = $this->getEntity($expression);
            return "<?php foreach {$expression}: {$entity} = {$entity}->present() ?>";
        });

        Blade::directive("endpresenteach", function ($expression) {
            return "<?php endforeach; ?>";
        });
    }

    private function getEntity($expression)
    {
        preg_match("/as (\\$[A-Z_]+)\)$/i", $expression, $matches);

        if (count($matches) !== 2) {
            throw new Exception("Invalid @presenteach expression: {$expression}");
        }

        return $matches[1];
    }

    public function register() {}
}
