<?php
namespace App\StarWars;

class CheckFuelCommand implements CommandInterface
{
    private FuelableInterface $object;

    public function __construct(FuelableInterface $object)
    {
        $this->object = $object;
    }

    public function execute(): void
    {
        if ($this->object->getFuelLevel() <= 0) {
            throw new CommandException("Not enough fuel");
        }
    }
}
