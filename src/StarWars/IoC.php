<?php

namespace App\StarWars;

use App\StarWars\IoC\IoCRegisterOperation;
use App\StarWars\IoC\ScopesNewOperation;
use App\StarWars\IoC\ScopesCurrentOperation;
use App\StarWars\IoC\OperationInterface;
use App\StarWars\IoC\IoCException;

class IoC
{
    private static ?ScopeStorage $scopeStorage = null;

    public static function Resolve(string $key, ...$args)
    {
        if (self::$scopeStorage === null) {
            self::$scopeStorage = new ScopeStorage();
        }

        switch ($key) {
            case 'IoC.Register':
                if (count($args) < 2) {
                    throw new IoCException("IoC.Register requires key and factory");
                }
                [$name, $factory] = $args;
                return new IoCRegisterOperation(
                    self::$scopeStorage->getCurrentScope(),
                    $name,
                    $factory
                );

            case 'Scopes.New':
                if (count($args) < 1) {
                    throw new IoCException("Scopes.New requires scopeId");
                }
                [$scopeId] = $args;
                return new ScopesNewOperation(self::$scopeStorage, $scopeId);

            case 'Scopes.Current':
                if (count($args) < 1) {
                    throw new IoCException("Scopes.Current requires scopeId");
                }
                [$scopeId] = $args;
                return new ScopesCurrentOperation(self::$scopeStorage, $scopeId);
        }

        $factory = self::$scopeStorage->getCurrentScope()->get($key);
        return $factory($args);
    }
}
