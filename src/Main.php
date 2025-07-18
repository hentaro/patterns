<?php

namespace App;
class Main
{
    public function solve(float $a, float $b, float $c): array
    {
        if (!is_finite($a) || !is_finite($b) || !is_finite($c)) {
            throw new \InvalidArgumentException("Коэффициенты должны быть конечными числами");
        }
        // Проверка на нулевой коэффициент a
        if (abs($a) < 1e-9) {
            throw new \InvalidArgumentException("Коэффициент 'a' не может быть равен 0");
        }
        // Вычисляем дискриминант
        $d = $b * $b - 4 * $a * $c;
        $eps = 1e-12;
        if($d > $eps){
            // Два корня
            $x1 = (-$b + sqrt($d)) / (2 * $a);
            $x2 = (-$b - sqrt($d)) / (2 * $a);
            return [$x1, $x2];
        }
        elseif(abs($d) <= $eps) {
            // Один корень
            $x = -$b / (2 * $a);
            return [$x];
        }
        //($d < 0)
        return []; // Нет действительных корней
    }

    /**
     * Минимальная реализация п.№4
     */

    public function solve4(float $a, float $b, float $c): array
    {
        if (abs($a) < 1e-9) {
            throw new \InvalidArgumentException("Коэффициент 'a' не может быть равен 0");
        }

        $d = $b * $b - 4 * $a * $c;

        if ($d < 0) {
            return [];
        }

        return [];
    }

    /**
     * Минимальная реализация п.№6
     */
    public function solve6(float $a, float $b, float $c): array
    {
        if (abs($a) < 1e-9) {
            throw new \InvalidArgumentException("Коэффициент 'a' не может быть равен 0");
        }

        $d = $b * $b - 4 * $a * $c;

        if ($d > 0) {
            $x1 = (-$b + sqrt($d)) / (2 * $a);
            $x2 = (-$b - sqrt($d)) / (2 * $a);
            return [$x1, $x2];
        }

        return []; // игнорируем D = 0 и D < 0
    }

    /**
     * Минимальная реализация п.№8
     */
    public function solve8(float $a, float $b, float $c): array
    {
        if (abs($a) < 1e-9) {
            throw new \InvalidArgumentException("Коэффициент 'a' не может быть равен 0");
        }

        $d = $b * $b - 4 * $a * $c;

        if (abs($d) < 1e-9) {
            return [-$b / (2 * $a)];
        }

        return [];
    }

}