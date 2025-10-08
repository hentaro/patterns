<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use App\StarWars\Adapter\AdapterGenerator;
use App\StarWars\Adapter\GeneratedAdapterFactory;
use App\StarWars\IoC;
use App\StarWars\IoC\IoCException;

interface TestMovable
{
    public function getPosition();
    public function setPosition($value);
    public function getVelocity();
    public function finish();
}

class HW6Test extends TestCase
{
    protected function setUp(): void
    {
        GeneratedAdapterFactory::register();
    }

    public function testGenerateAdapterClass()
    {
        $obj = new \stdClass();
        $obj->position = "initial";
        $obj->velocity = "fast";

        // Моки IoC
        IoC::Resolve("IoC.Register", "App\\Test\\TestMovable:position.get", fn($args) => $args[0]->position)->execute();
        IoC::Resolve("IoC.Register", "App\\Test\\TestMovable:velocity.get", fn($args) => $args[0]->velocity)->execute();
        IoC::Resolve("IoC.Register", "App\\Test\\TestMovable:position.set", function($args) {
            $args[0]->position = $args[1];
            return new class {
                public function execute() {}
            };
        })->execute();
        IoC::Resolve("IoC.Register", "App\\Test\\TestMovable:finish", function($args) {
            return new class {
                public function execute() { }
            };
        })->execute();

        $adapter = AdapterGenerator::create(TestMovable::class, $obj);

        $this->assertSame("initial", $adapter->getPosition());
        $this->assertSame("fast", $adapter->getVelocity());

        $adapter->setPosition("new");
        $this->assertSame("new", $adapter->getPosition());

        $adapter->finish();

        $this->assertTrue(true);
    }

    public function testThrowsIfInterfaceMissing()
    {
        $this->expectException(IoCException::class);
        AdapterGenerator::create("NonExistentInterface", new \stdClass());
    }
}
