<?php

namespace App\StarWars\IoC;

use App\StarWars\Scope;

class IoCRegisterOperation implements OperationInterface
{
    private Scope $scope;
    private string $key;
    private $factory;

    public function __construct(Scope $scope, string $key, callable $factory)
    {
        $this->scope = $scope;
        $this->key = $key;
        $this->factory = $factory;
    }

    public function execute(): void
    {
        $this->scope->register($this->key, $this->factory);
    }
}
