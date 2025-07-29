<?php

namespace App\StarWars;

//use App\StarWars\RotatableInterface;
class RotateEngine
{
    public function execute(RotatableInterface $object): void
    {
        $angle = $object->getAngle();
        $delta = $object->getAngularVelocity();

        $object->setAngle($angle + $delta);
    }
}
