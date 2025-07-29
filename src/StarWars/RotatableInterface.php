<?php

namespace App\StarWars;

interface RotatableInterface
{
    /**
     * Возвращает текущий угол (в градусах, целое число).
     */
    public function getAngle(): int;

    /**
     * Устанавливает новый угол.
     */
    public function setAngle(int $angle): void;

    /**
     * Возвращает угловую скорость (в градусах за шаг, целое число).
     */
    public function getAngularVelocity(): int;
}
