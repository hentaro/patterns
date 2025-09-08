<?php
namespace App\StarWars;

class BurnFuelCommand implements CommandInterface
{
    private FuelableInterface $object;

    public function __construct(FuelableInterface $object)
    {
        $this->object = $object;
    }

    public function execute(): void
    {
        $fuel = $this->object->getFuelLevel();
        $rate = $this->object->getFuelConsumptionRate();

        if ($fuel < $rate) {
            throw new CommandException("Not enough fuel to burn");
        }

        $this->object->setFuelLevel($fuel - $rate);
    }
}
