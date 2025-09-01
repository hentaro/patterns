<?php

namespace App\HW3\Command;

class LogCommand implements CommandInterface {
    public function __construct(private string $message) {}

    public function execute(): void {
        echo "[LOG]: {$this->message}\n";
    }
}
