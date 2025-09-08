<?php

namespace App\Test;

use App\StarWars\{CommandException,
    CheckFuelCommand,
    BurnFuelCommand,
    CommandInterface,
    MacroCommand,
    MoveCommand,
    RotateAndChangeVelocityCommand,
    RotateEngineCommand,
    FuelableInterface,
    MovableInterface,
    RotatableInterface,
    MovementEngine,
    RotateEngine};
use PHPUnit\Framework\TestCase;

class HW4Test extends TestCase
{
    /**
     * Тест: CheckFuelCommand выбрасывает исключение, если топлива нет
     */
    public function testCheckFuelThrowsIfNoFuel(): void
    {
        $mock = $this->createMock(FuelableInterface::class);
        $mock->method('getFuelLevel')->willReturn(0);

        $command = new CheckFuelCommand($mock);

        $this->expectException(CommandException::class);
        $this->expectExceptionMessage("Not enough fuel");

        $command->execute();
    }

    /**
     * Тест: CheckFuelCommand проходит, если топлива достаточно
     */
    public function testCheckFuelPassesIfFuelExists(): void
    {
        $mock = $this->createMock(FuelableInterface::class);
        $mock->method('getFuelLevel')->willReturn(10);

        $command = new CheckFuelCommand($mock);

        $command->execute();

        $this->assertTrue(true); // просто доходит без исключений
    }

    /**
     * Тест: BurnFuelCommand уменьшает топливо
     */
    public function testBurnFuelReducesFuel(): void
    {
        $mock = $this->createMock(FuelableInterface::class);

        $mock->method('getFuelLevel')->willReturn(10);
        $mock->method('getFuelConsumptionRate')->willReturn(3);

        $mock->expects($this->once())
            ->method('setFuelLevel')
            ->with(7);

        $command = new BurnFuelCommand($mock);
        $command->execute();
    }

    /**
     * Тест: BurnFuelCommand выбрасывает исключение, если топлива меньше расхода
     */
    public function testBurnFuelThrowsIfNotEnough(): void
    {
        $mock = $this->createMock(FuelableInterface::class);

        $mock->method('getFuelLevel')->willReturn(2);
        $mock->method('getFuelConsumptionRate')->willReturn(5);

        $command = new BurnFuelCommand($mock);

        $this->expectException(CommandException::class);
        $this->expectExceptionMessage("Not enough fuel to burn");

        $command->execute();
    }

    /**
     * Тест: MacroCommand выполняет все команды
     */
    public function testMacroCommandExecutesAll(): void
    {
        $cmd1 = $this->createMock(CommandInterface::class);
        $cmd2 = $this->createMock(CommandInterface::class);

        $cmd1->expects($this->once())->method('execute');
        $cmd2->expects($this->once())->method('execute');

        $macro = new MacroCommand([$cmd1, $cmd2]);
        $macro->execute();
    }

    /**
     * Тест: MacroCommand останавливается на исключении
     */
    public function testMacroCommandStopsOnException(): void
    {
        $cmd1 = $this->createMock(CommandInterface::class);
        $cmd2 = $this->createMock(CommandInterface::class);

        $cmd1->method('execute')->willThrowException(new CommandException("Fail"));
        $cmd2->expects($this->never())->method('execute');

        $macro = new MacroCommand([$cmd1, $cmd2]);

        $this->expectException(CommandException::class);
        $this->expectExceptionMessage("Fail");

        $macro->execute();
    }

    /**
     * Тест: MoveCommand вызывает MovementEngine
     */
    public function testMoveCommandCallsEngine(): void
    {
        $movable = $this->createMock(MovableInterface::class);
        $engine = $this->createMock(MovementEngine::class);

        $engine->expects($this->once())
            ->method('execute')
            ->with($movable);

        $command = new MoveCommand($movable, $engine);
        $command->execute();
    }

    /**
     * Тест: RotateEngineCommand вызывает RotateEngine
     */
    public function testRotateEngineCommandCallsEngine(): void
    {
        $rotatable = $this->createMock(RotatableInterface::class);
        $engine = $this->createMock(RotateEngine::class);

        $engine->expects($this->once())
            ->method('execute')
            ->with($rotatable);

        $command = new RotateEngineCommand($rotatable, $engine);
        $command->execute();
    }

    /**
     * Тест: RotateAndChangeVelocityCommand меняет вектор скорости
     */
    public function testRotateAndChangeVelocityCommandChangesVelocity(): void
    {
        $rotatable = $this->createMock(RotatableInterface::class);
        $movable = $this->getMockBuilder(MovableInterface::class)
            ->getMock();

        $rotatable->method('getAngle')->willReturn(90);
        $movable->method('getVelocity')->willReturn(['vx' => 1, 'vy' => 0]);
        $movable->method('getPosition')->willReturn(['x' => 0, 'y' => 0]);

        $movable->expects($this->once())
            ->method('setVelocity')
            ->with(0, 1);

        $command = new RotateAndChangeVelocityCommand($rotatable, $movable);
        $command->execute();
    }
}
