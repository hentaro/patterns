<?php

namespace App\StarWars;

use App\StarWars\RotatableInterface;

class RotatableObject implements RotatableInterface
{
    private int $angle;
    private int $angularVelocity;

    public function __construct(int $angle, int $angularVelocity)
    {
        $this->angle = $angle;
        $this->angularVelocity = $angularVelocity;
    }

    public function getAngle(): int
    {
        return $this->angle;
    }

    public function setAngle(int $angle): void
    {
        $this->angle = $angle;
    }

    public function getAngularVelocity(): int
    {
        return $this->angularVelocity;
    }
}
