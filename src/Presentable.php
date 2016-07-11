<?php

namespace SmallHadronCollider\AnaloguePresenter;

use Exception;
use Analogue\ORM\System\Manager;

trait Presentable
{
    protected $presenterObject;

    public function present()
    {
        if (!$this->presenterObject) {
            $this->presenterObject = $this->generatePresenter();
        }

        return $this->presenterObject;
    }

    protected function generatePresenter()
    {
        $manager = Manager::getInstance();
        $entityMap = $manager->mapper($this)->getEntityMap();

        if (!$entityMap->presenter) {
            throw new Exception("No presenter set for " . get_class($entityMap));
        }

        $presenter = $entityMap->presenter;

        return new $presenter($this);
    }
}
