<?php

namespace App\HW3\Exception;

use App\HW3\Command\CommandInterface;
use App\HW3\Command\CommandQueue;

interface ExceptionHandlerInterface {
    public function handle(\Throwable $e, CommandInterface $command, CommandQueue $queue): void;
    public function supports(\Throwable $e, CommandInterface $command): bool;
}