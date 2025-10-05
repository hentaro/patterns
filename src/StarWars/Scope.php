<?php

namespace App\StarWars;

use App\StarWars\IoC\IoCException;

class Scope
{
    private array $registrations = [];

    public function register(string $key, callable $factory): void
    {
        $this->registrations[$key] = $factory;
    }

    public function get(string $key): callable
    {
        if (!isset($this->registrations[$key])) {
            throw new IoCException("Dependency not found: $key");
        }
        return $this->registrations[$key];
    }
}
