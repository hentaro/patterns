<?php
namespace App\StarWars;

class MoveCommand implements CommandInterface
{
    private MovableInterface $object;
    private MovementEngine $engine;

    public function __construct(MovableInterface $object, MovementEngine $engine)
    {
        $this->object = $object;
        $this->engine = $engine;
    }

    public function execute(): void
    {
        $this->engine->execute($this->object);
    }
}
