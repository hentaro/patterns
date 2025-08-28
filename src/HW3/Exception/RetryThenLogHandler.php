<?php

namespace App\HW3\Exception;

use App\HW3\Command\CommandInterface;
use App\HW3\Command\CommandQueue;
use App\HW3\Command\RetryCommand;
use App\HW3\Command\LogCommand;

class RetryThenLogHandler implements ExceptionHandlerInterface {
    private array $attempts = [];

    public function supports(\Throwable $e, CommandInterface $command): bool {
        return true;
    }

    public function handle(\Throwable $e, CommandInterface $command, CommandQueue $queue): void {
        $hash = spl_object_hash($command);
        $this->attempts[$hash] = ($this->attempts[$hash] ?? 0) + 1;

        if ($this->attempts[$hash] === 1 && !($command instanceof RetryCommand)) {
            $queue->add(new RetryCommand($command));
        } else {
            $queue->add(new LogCommand("Command failed twice: " . get_class($command)));
        }
    }
}
