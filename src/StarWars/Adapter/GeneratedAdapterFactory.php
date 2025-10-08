<?php

namespace App\StarWars\Adapter;

use App\StarWars\IoC;
use App\StarWars\IoC\IoCException;

class GeneratedAdapterFactory
{
    public static function register(): void
    {
        IoC::Resolve("IoC.Register", "Adapter", function (array $args) {
            if (count($args) < 2) {
                throw new IoCException("Adapter factory requires interfaceName and object");
            }
            [$interfaceName, $object] = $args;
            return AdapterGenerator::create($interfaceName, $object);
        })->execute();
    }
}
