<?php

namespace App\StarWars;

use App\StarWars\MovableInterface;
class MovableObject implements MovableInterface
{
    private int $x;
    private int $y;
    private int $vx;
    private int $vy;

    public function __construct(int $x, int $y, int $vx, int $vy)
    {
        $this->x = $x;
        $this->y = $y;
        $this->vx = $vx;
        $this->vy = $vy;
    }

    public function getPosition(): array
    {
        return ['x' => $this->x, 'y' => $this->y];
    }

    public function setPosition(int $x, int $y): void
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function getVelocity(): array
    {
        return ['vx' => $this->vx, 'vy' => $this->vy];
    }

    public function setVelocity(int $vx, int $vy): void
    {
        $this->vx = $vx;
        $this->vy = $vy;
    }

    public function move(): void
    {
        $this->x += $this->vx;
        $this->y += $this->vy;
    }
}
