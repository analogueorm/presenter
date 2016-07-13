<?php

namespace Analogue\Presenter;

use Carbon\Carbon;

class NullPresenter
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __call($name, $arguments)
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
