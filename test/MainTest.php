<?php

namespace App\Test;

use App\Main;
use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    public function testTwoRealRoots(): void
    {
        $solver = new Main();
        $res = $solver->solve(1, -3, 2);
        sort($res);
        $this->assertEquals([1.0, 2.0], $res);
    }

    public function testOneRealRoot(): void
    {
        $solver = new Main();
        $res = $solver->solve(1, -2, 1);
        $this->assertEquals([1.0], $res);
    }

    public function testNoRealRoots(): void
    {
        $solver = new Main();
        $res = $solver->solve(1, 0, 1);
        $this->assertEmpty($res);
    }

    public function testZeroAThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new Main())->solve(0, 2, 1);
    }

    // x^2 + 1 = 0
    public function testNoRealRootsForXSquaredPlus1(): void
    {
        $solver = new Main();
        // Основная реализация
        $res = $solver->solve(1.0, 0.0, 1.0);
        $this->assertEquals([], $res);
        // Минимальная реализация
        $res4 = $solver->solve4(1.0, 0.0, 1.0);
        $this->assertEquals([], $res4);
    }

    // x^2 - 1 = 0
    public function testTwoDistinctRoots(): void
    {
        $solver = new Main();
        // Основная реализация
        $res = $solver->solve(1.0, 0.0, -1.0);
        sort($res);
        $this->assertEquals([-1.0, 1.0], $res);
        // Минимальная реализация
        $res6 = $solver->solve6(1.0, 0.0, -1.0);
        sort($res6);
        $this->assertEquals([-1.0, 1.0], $res6);
    }

    // x^2 + 2x + 1 = 0
    public function testOneDoubleRoot(): void
    {
        $solver = new Main();
        // Основная реализация
        $res = $solver->solve(1.0, 2.0, 1.0);
        sort($res);
        $this->assertEquals([-1.0], $res);
        // Минимальная реализация
        $res8 = $solver->solve8(1.0, 2.0, 1.0);
        sort($res8);
        $this->assertEquals([-1.0], $res8);
    }

    public function testZeroACoefficientThrows(): void
    {
        $solver = new Main();
        $this->expectException(\InvalidArgumentException::class);
        $solver->solve(0.0, 2.0, 1.0);
    }

    // п.11
    public function testDoubleRootWithNearZeroDiscriminant(): void
    {
        $solver = new Main();
        $res = $solver->solve(1.0, 2.0, 1.000000000000001); // D < 0, но близок к 0
        sort($res);
        $this->assertEquals([-1.0], $res); // всё ещё один корень
        // Минимальная реализация
        $res8 = $solver->solve8(1.0, 2.0, 1.000000000000001); // D < 0, но близок к 0
        sort($res8);
        $this->assertEquals([-1.0], $res8); // всё ещё один корень
    }

    // п.13 нечисловые значения
    public function testNonFiniteCoefficientsThrowException(): void
    {
        $solver = new Main();

        $badValues = [INF, -INF, NAN];

        foreach ($badValues as $value) {
            foreach (['a', 'b', 'c'] as $var) {
                $a = 1.0; $b = 0.0; $c = 0.0;

                if ($var === 'a') $a = $value;
                if ($var === 'b') $b = $value;
                if ($var === 'c') $c = $value;

                try {
                    $solver->solve($a, $b, $c);
                    $this->fail("Ожидалось исключение для $var = $value");
                } catch (\InvalidArgumentException $e) {
                    $this->assertTrue(true);
                }
            }
        }
    }
}