<?php

namespace App\StarWars;
class MovementEngine
{
    public function execute(MovableInterface $object): void
    {
        $position = $object->getPosition();
        $velocity = $object->getVelocity();

        $object->setPosition(
            $position['x'] + $velocity['vx'],
            $position['y'] + $velocity['vy']
        );
    }
}