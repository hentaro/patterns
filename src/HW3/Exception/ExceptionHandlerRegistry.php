<?php

namespace App\HW3\Exception;

use App\HW3\Command\CommandInterface;

class ExceptionHandlerRegistry {
    /** @var ExceptionHandlerInterface[] */
    private array $handlers = [];

    public function addHandler(ExceptionHandlerInterface $handler): void {
        $this->handlers[] = $handler;
    }

    public function getHandler(\Throwable $e, CommandInterface $command): ?ExceptionHandlerInterface {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($e, $command)) {
                return $handler;
            }
        }
        return null;
    }
}
