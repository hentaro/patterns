<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use App\HW3\Command\LogCommand;
use App\HW3\Command\RetryCommand;
use App\HW3\Command\RetryOnceCommand;
use App\HW3\Command\FailingCommand;
use App\HW3\Command\CommandInterface;
use App\HW3\Command\CommandQueue;
use App\HW3\Command\CommandProcessor;
use App\HW3\Exception\LogExceptionHandler;
use App\HW3\Exception\RetryExceptionHandler;
use App\HW3\Exception\RetryThenLogHandler;
use App\HW3\Exception\ExceptionHandlerRegistry;

class HW3Test extends TestCase
{
    // 🔹 Пункт 4: Команда, пишущая в лог
    public function testLogCommandOutputsMessageToLog(): void
    {
        $this->expectOutputString("[LOG]: Log message\n");
        $command = new LogCommand("Log message");
        $command->execute();
    }

    // 🔹 Пункт 5: Обработчик исключений ставит LogCommand в очередь
    public function testLogExceptionHandlerAddsLogCommandToQueue(): void
    {
        $queue = new CommandQueue();
        $handler = new LogExceptionHandler();

        $mockCommand = $this->createMock(CommandInterface::class);

        $handler->handle(new \RuntimeException("Exception message!"), $mockCommand, $queue);

        $this->assertFalse($queue->isEmpty(), "Queue should contain a LogCommand");
        $this->assertInstanceOf(LogCommand::class, $queue->getNext());
    }

    // 🔹 Пункт 6: Команда, повторяющая другую команду
    public function testRetryCommandExecutesOriginalCommand(): void
    {
        $mockCommand = $this->createMock(CommandInterface::class);
        $mockCommand->expects($this->once())
            ->method('execute');

        $retry = new RetryCommand($mockCommand);
        $retry->execute();
    }

    // 🔹 Пункт 7: Обработчик исключений ставит RetryCommand в очередь
    public function testRetryExceptionHandlerAddsRetryCommandToQueue(): void
    {
        $queue = new CommandQueue();
        $handler = new RetryExceptionHandler();

        $mockCommand = $this->createMock(CommandInterface::class);

        $handler->handle(new \RuntimeException("Exception message!"), $mockCommand, $queue);

        $this->assertFalse($queue->isEmpty(), "Queue should contain a RetryCommand");
        $this->assertInstanceOf(RetryCommand::class, $queue->getNext());
    }

    // 🔹 Пункт 8: Первый раз повторить, второй раз логировать
    public function testRetryThenLogHandlerRetriesFirstTimeAndLogsSecondTime(): void
    {
        $queue = new CommandQueue();
        $handler = new RetryThenLogHandler();

        $mockCommand = $this->createMock(CommandInterface::class);

        // Первый вызов -> RetryCommand
        $handler->handle(new \RuntimeException("Exception message!"), $mockCommand, $queue);
        $first = $queue->getNext();
        $this->assertInstanceOf(RetryCommand::class, $first, "First failure should retry");

        // Второй вызов -> LogCommand
        $handler->handle(new \RuntimeException("Exception message!"), $mockCommand, $queue);
        $second = $queue->getNext();
        $this->assertInstanceOf(LogCommand::class, $second, "Second failure should log");
    }

    // 🔹 Пункт 9: Повторить два раза, потом логировать
    public function testRetryOnceCommandFailsTwiceThenIsLogged(): void
    {
        $queue = new CommandQueue();
        $handlers = new ExceptionHandlerRegistry();
        $handlers->addHandler(new RetryThenLogHandler());

        $mockFailing = $this->createMock(CommandInterface::class);
        $mockFailing->method('execute')
            ->willThrowException(new \RuntimeException("Boom!"));

        $command = new RetryOnceCommand($mockFailing);
        $queue->add($command);

        $processor = new CommandProcessor($queue, $handlers);
        $processor->run();

        // Проверяем, что после двух попыток команда залогировалась
        $this->assertTrue($queue->isEmpty(), "Queue should eventually be empty after processing");
    }
}
