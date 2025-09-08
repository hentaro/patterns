<?php

namespace App\StarWars;

use App\StarWars\RotatableInterface;
use App\StarWars\RotateEngine;
use App\StarWars\CommandException;

/**
 * Команда для вращения объекта через RotateEngine.
 */
class RotateEngineCommand implements CommandInterface
{
    private RotateEngine $engine;
    private RotatableInterface $object;

    public function __construct(RotatableInterface $object, RotateEngine $engine)
    {
        $this->object = $object;
        $this->engine = $engine;
    }

    /**
     * Выполняет вращение объекта.
     *
     * @throws CommandException
     */
    public function execute(): void
    {
        try {
            $this->engine->execute($this->object);
        } catch (\Throwable $e) {
            // Заворачиваем любое исключение в CommandException
            throw new CommandException("Ошибка при повороте объекта", 0, $e);
        }
    }
}
