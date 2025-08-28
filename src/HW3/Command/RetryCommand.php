<?php

namespace App\HW3\Command;

class RetryCommand implements CommandInterface {
    public function __construct(private CommandInterface $originalCommand) {}

    public function execute(): void {
        $this->originalCommand->execute();
    }
}
