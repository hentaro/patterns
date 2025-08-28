<?php

namespace App\HW3\Exception;

use App\HW3\Command\CommandInterface;
use App\HW3\Command\CommandQueue;
use App\HW3\Command\RetryCommand;

class RetryExceptionHandler implements ExceptionHandlerInterface {
    public function supports(\Throwable $e, CommandInterface $command): bool {
        return true;
    }

    public function handle(\Throwable $e, CommandInterface $command, CommandQueue $queue): void {
        $queue->add(new RetryCommand($command));
    }
}
