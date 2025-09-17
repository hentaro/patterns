<?php
namespace App\StarWars;

class MacroCommand implements CommandInterface
{
    /** @var CommandInterface[] */
    private array $commands;

    /**
     * @param CommandInterface[] $commands
     */
    public function __construct(array $commands)
    {
        $this->commands = $commands;
    }

    public function execute(): void
    {
        foreach ($this->commands as $command) {
            $command->execute();
        }
    }
}
