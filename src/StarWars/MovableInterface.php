<?php

namespace App\StarWars;

interface MovableInterface
{
    /**
     * Возвращает текущие координаты объекта.
     *
     * @return array{x: int, y: int}
     */
    public function getPosition(): array;

    /**
     * Устанавливает новые координаты объекта.
     *
     * @param int $x
     * @param int $y
     * @return void
     */
    public function setPosition(int $x, int $y): void;

    /**
     * Возвращает текущую скорость объекта.
     *
     * @return array{vx: int, vy: int}
     */
    public function getVelocity(): array;
}
