<?php

namespace App\HW3\Command;

class RetryOnceCommand implements CommandInterface {
    private int $attempts = 0;

    public function __construct(private CommandInterface $originalCommand) {}

    public function execute(): void {
        $this->attempts++;
        if ($this->attempts > 1) {
            throw new \RuntimeException("Command failed twice");
        }
        $this->originalCommand->execute();
    }
}
