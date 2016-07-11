<?php

namespace SmallHadronCollider\AnaloguePresenter;

use Carbon\Carbon;

abstract class Presenter
{
    protected $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function __call($name, $arguments)
    {
        return $this->entity->{$name};
    }

    protected function carbon($date)
    {
        return new Carbon($date);
    }
}
