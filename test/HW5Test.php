<?php

use PHPUnit\Framework\TestCase;
use App\StarWars\IoC;
use App\StarWars\IoC\IoCException;

class HW5Test extends TestCase
{
    public function testRegisterAndResolveDependency()
    {
        // Регистрируем зависимость
        IoC::Resolve("IoC.Register", "foo", fn() => "bar")->execute();

        $result = IoC::Resolve("foo");
        $this->assertEquals("bar", $result);
    }

    public function testSwitchScopes()
    {
        // Создаем новый скоуп и переключаемся
        IoC::Resolve("Scopes.New", "scope1")->execute();
        IoC::Resolve("IoC.Register", "foo", fn() => "bar1")->execute();

        $this->assertEquals("bar1", IoC::Resolve("foo"));

        // Второй скоуп
        IoC::Resolve("Scopes.New", "scope2")->execute();
        IoC::Resolve("IoC.Register", "foo", fn() => "bar2")->execute();

        $this->assertEquals("bar2", IoC::Resolve("foo"));

        // Возвращаемся в первый
        IoC::Resolve("Scopes.Current", "scope1")->execute();
        $this->assertEquals("bar1", IoC::Resolve("foo"));
    }

    public function testResolveThrowsExceptionIfNotFound()
    {
        $this->expectException(IoCException::class);
        IoC::Resolve("unknownKey");
    }

    public function testRegisterThrowsIfArgumentsMissing()
    {
        $this->expectException(IoCException::class);
        IoC::Resolve("IoC.Register")->execute();
    }

    public function testScopesNewThrowsIfArgumentsMissing()
    {
        $this->expectException(IoCException::class);
        IoC::Resolve("Scopes.New")->execute();
    }

    public function testScopesCurrentThrowsIfScopeNotExists()
    {
        $this->expectException(IoCException::class);
        IoC::Resolve("Scopes.Current", "nonexistent")->execute();
    }

    public function testMultithreadingSimulation()
    {
        // параллельность вместо потоков
        IoC::Resolve("Scopes.New", "thread1")->execute();
        IoC::Resolve("IoC.Register", "val", fn() => "t1")->execute();
        $val1 = IoC::Resolve("val");

        IoC::Resolve("Scopes.New", "thread2")->execute();
        IoC::Resolve("IoC.Register", "val", fn() => "t2")->execute();
        $val2 = IoC::Resolve("val");

        $this->assertEquals("t1", $val1);
        $this->assertEquals("t2", $val2);
    }
}
