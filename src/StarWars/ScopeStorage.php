<?php

namespace App\StarWars;

use App\StarWars\IoC\IoCException;

class ScopeStorage
{
    private array $scopes = [];
    private ?Scope $current = null;

    public function newScope(string $id): void
    {
        $this->scopes[$id] = new Scope();
        $this->current = $this->scopes[$id];
    }

    public function setCurrentScope(string $id): void
    {
        if (!isset($this->scopes[$id])) {
            throw new IoCException("Scope not found: $id");
        }
        $this->current = $this->scopes[$id];
    }

    public function getCurrentScope(): Scope
    {
        if ($this->current === null) {
            $this->newScope('default');
        }
        return $this->current;
    }
}
