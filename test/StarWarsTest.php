<?php

namespace App\Test;

use App\StarWars\MovableInterface;
use App\StarWars\MovableObject;
use App\StarWars\MovementEngine;
use App\StarWars\RotatableInterface;
use App\StarWars\RotateEngine;
use PHPUnit\Framework\TestCase;

class StarWarsTest extends TestCase
{
    /**
     * Для объекта, находящегося в точке (12, 5) и движущегося со скоростью (-7, 3) движение меняет положение объекта на (5, 8)
     * @return void
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testMovementEngine(): void
    {
        $mock = $this->createMock(MovableInterface::class);

        // Координаты и скорость
        $mock->method('getPosition')
            ->willReturn(['x' => 12, 'y' => 5]);

        $mock->method('getVelocity')
            ->willReturn(['vx' => -7, 'vy' => 3]);

        // Ожидаем, что setPosition будет вызван ровно один раз с (5, 8)
        $mock->expects($this->once())
            ->method('setPosition')
            ->with(5, 8);

        $movementEngine = new MovementEngine();

        $movementEngine->execute($mock);
    }

    /**
     * Попытка сдвинуть объект, у которого невозможно прочитать положение в пространстве, приводит к ошибке
     * @return void
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testMoveThrowsExceptionIfGetPositionFails()
    {
        // Создаем заглушку, которая выбрасывает исключение при getPosition
        $mock = $this->createMock(MovableInterface::class);

        $mock->method('getPosition')
            ->will($this->throwException(new \RuntimeException('Cannot get position')));

        // Чтобы не мешало, остальные методы можно заглушить обычным возвратом
        $mock->method('getVelocity')->willReturn(['vx' => 1, 'vy' => 1]);

        // Заглушка для setPosition (void)
        $mock->method('setPosition');

        $movementEngine = new MovementEngine();

        // Ожидаем, что при вызове move будет выброшено RuntimeException
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Cannot get position');

        $movementEngine->execute($mock);
    }

    /**
     * Попытка сдвинуть объект, у которого невозможно прочитать значение мгновенной скорости, приводит к ошибке
     * @return void
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testMoveThrowsExceptionIfGetVelocityFails()
    {
        $mock = $this->createMock(MovableInterface::class);

        // getPosition возвращает корректные данные
        $mock->method('getPosition')
            ->willReturn(['x' => 12, 'y' => 5]);

        // getVelocity выбрасывает исключение
        $mock->method('getVelocity')
            ->will($this->throwException(new \RuntimeException('Cannot get velocity')));

        // Заглушка для setPosition (void)
        $mock->method('setPosition');

        $movementEngine = new MovementEngine();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Cannot get velocity');

        $movementEngine->execute($mock);
    }

    /**
     * Попытка сдвинуть объект, у которого невозможно изменить положение в пространстве, приводит к ошибке
     * @return void
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testMoveThrowsExceptionIfSetPositionFails()
    {
        $mock = $this->createMock(MovableInterface::class);

        // getPosition возвращает корректные данные
        $mock->method('getPosition')
            ->willReturn(['x' => 12, 'y' => 5]);

        // getVelocity возвращает корректные данные
        $mock->method('getVelocity')
            ->willReturn(['vx' => -7, 'vy' => 3]);

        // setPosition выбрасывает исключение
        $mock->method('setPosition')
            ->will($this->throwException(new \RuntimeException('Cannot set position')));

        $movementEngine = new MovementEngine();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Cannot set position');

        $movementEngine->execute($mock);
    }

    /**
     * Тест поворота
     * @return void
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testRotateEngine(): void
    {
        $mock = $this->createMock(RotatableInterface::class);

        // Начальное значение
        $mock->method('getAngle')
            ->willReturn(45);

        // Угловая скорость
        $mock->method('getAngularVelocity')
            ->willReturn(5);

        // Ожидаем, что setAngle будет вызван один раз с аргументом 50
        $mock->expects($this->once())
            ->method('setAngle')
            ->with(50);

        $rotateEngine = new RotateEngine();

        $rotateEngine->execute($mock);
    }

    /**
     * Тест поворота с отрицательной скоростью
     * @return void
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testRotateEngineWithNegativeAngularVelocity()
    {
        $mock = $this->createMock(RotatableInterface::class);

        // Исходный угол: 50, угловая скорость: -10 → ожидаем угол 40
        $mock->method('getAngle')
            ->willReturn(50);

        $mock->method('getAngularVelocity')
            ->willReturn(-10);

        $mock->expects($this->once())
            ->method('setAngle')
            ->with(40);

        $rotateEngine = new RotateEngine();

        $rotateEngine->execute($mock);
    }

    /**
     * Попытка повернуть объект, у которого невозможно прочитать угол поворота, приводит к ошибке
     * @return void
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testRotateThrowsExceptionIfGetAngleFails()
    {
        $mock = $this->createMock(RotatableInterface::class);

        $mock->method('getAngle')
            ->will($this->throwException(new \RuntimeException('Cannot get angle')));

        $mock->method('getAngularVelocity')
            ->willReturn(1);

        // Заглушка для setAngle (void)
        $mock->method('setAngle');

        $movementEngine = new RotateEngine();

        // Ожидаем, что при вызове move будет выброшено RuntimeException
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Cannot get angle');

        $movementEngine->execute($mock);
    }

    /**
     * Попытка повернуть объект, у которого невозможно прочитать значение скорости поворота, приводит к ошибке
     * @return void
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testRotateThrowsExceptionIfGetAngularVelocityFails()
    {
        $mock = $this->createMock(RotatableInterface::class);

        $mock->method('getAngle')
            ->willReturn(90);

        $mock->method('getAngularVelocity')
            ->will($this->throwException(new \RuntimeException('Cannot get angular velocity')));

        // Заглушка для setAngle (void)
        $mock->method('setAngle');

        $movementEngine = new RotateEngine();

        // Ожидаем, что при вызове move будет выброшено RuntimeException
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Cannot get angular velocity');

        $movementEngine->execute($mock);
    }

    /**
     * Попытка повернуть объект, у которого невозможно изменить угол поворота, приводит к ошибке
     * @return void
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testRotateThrowsExceptionIfSetAngleFails()
    {
        $mock = $this->createMock(RotatableInterface::class);

        $mock->method('getAngle')
            ->willReturn(90);

        $mock->method('getAngularVelocity')
            ->willReturn(1);

        // setAngle выбрасывает исключение
        $mock->method('setAngle')
            ->will($this->throwException(new \RuntimeException('Cannot set angle')));

        $movementEngine = new RotateEngine();

        // Ожидаем, что при вызове move будет выброшено RuntimeException
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Cannot set angle');

        $movementEngine->execute($mock);
    }
}