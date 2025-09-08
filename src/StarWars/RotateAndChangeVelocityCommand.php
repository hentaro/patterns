<?php
namespace App\StarWars;

class RotateAndChangeVelocityCommand implements CommandInterface
{
    private RotatableInterface $rotatable;
    private ?MovableInterface $movable;

    public function __construct(RotatableInterface $rotatable, ?MovableInterface $movable = null)
    {
        $this->rotatable = $rotatable;
        $this->movable = $movable;
    }

    public function execute(): void
    {
        $angle = $this->rotatable->getAngle();

        if ($this->movable !== null) {
            $velocity = $this->movable->getVelocity();
            $vx = $velocity['vx'];
            $vy = $velocity['vy'];

            // поворот вектора скорости по углу (2D rotation matrix)
            $rad = deg2rad($angle);
            $newVx = (int) round($vx * cos($rad) - $vy * sin($rad));
            $newVy = (int) round($vx * sin($rad) + $vy * cos($rad));

            $this->movable->setPosition(
                $this->movable->getPosition()['x'],
                $this->movable->getPosition()['y']
            );

            $this->movable->setVelocity($newVx, $newVy);
        }
    }
}
