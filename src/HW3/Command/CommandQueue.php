<?php

namespace App\HW3\Command;

class CommandQueue {
    private array $queue = [];

    public function add(CommandInterface $command): void {
        $this->queue[] = $command;
    }

    public function getNext(): ?CommandInterface {
        return array_shift($this->queue);
    }

    public function isEmpty(): bool {
        return empty($this->queue);
    }
}
