<?php
namespace App\StarWars;

interface FuelableInterface
{
    public function getFuelLevel(): int;
    public function setFuelLevel(int $fuel): void;
    public function getFuelConsumptionRate(): int;
}