<?php

namespace App\HW3\Exception;

use App\HW3\Command\CommandInterface;
use App\HW3\Command\CommandQueue;
use App\HW3\Command\LogCommand;

class LogExceptionHandler implements ExceptionHandlerInterface {
    public function supports(\Throwable $e, CommandInterface $command): bool {
        return true;
    }

    public function handle(\Throwable $e, CommandInterface $command, CommandQueue $queue): void {
        $queue->add(new LogCommand("Exception: {$e->getMessage()} in command " . get_class($command)));
    }
}
