<?php

namespace App\HW3\Command;

// Простая команда, которая всегда кидает исключение
class FailingCommand implements CommandInterface {
    public function execute(): void {
        throw new \RuntimeException("Exception message!");
    }
}