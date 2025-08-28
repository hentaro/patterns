<?php

namespace App\HW3\Command;

use App\HW3\Exception\ExceptionHandlerRegistry;

class CommandProcessor {
    public function __construct(
        private CommandQueue $queue,
        private ExceptionHandlerRegistry $handlers
    ) {}

    public function run(): void {
        while (!$this->queue->isEmpty()) {
            $command = $this->queue->getNext();
            try {
                $command->execute();
            } catch (\Throwable $e) { // перехватываем только базовое исключение
                $handler = $this->handlers->getHandler($e, $command);
                if ($handler) {
                    $handler->handle($e, $command, $this->queue);
                }
            }
        }
    }
}
