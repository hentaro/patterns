<?php
namespace App\StarWars;

interface CommandInterface
{
    /**
     * Выполняет команду
     *
     * @throws CommandException
     */
    public function execute(): void;
}