<?php

namespace App\StarWars\IoC;

use App\StarWars\ScopeStorage;

class ScopesCurrentOperation implements OperationInterface
{
    private ScopeStorage $storage;
    private string $scopeId;

    public function __construct(ScopeStorage $storage, string $scopeId)
    {
        $this->storage = $storage;
        $this->scopeId = $scopeId;
    }

    public function execute(): void
    {
        $this->storage->setCurrentScope($this->scopeId);
    }
}
