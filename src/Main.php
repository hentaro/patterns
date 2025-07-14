<?php

class Main
{
	public function solve(float $a, float $b, float $c): array
	{
		// Проверка на нулевой коэффициент a
		if ($a === 0.0) {
			return [];
		}
		// Вычисляем дискриминант
		$d = $b * $b - 4 * $a * $c;
		if ($d > 0){
			// Два корня
			$x1 = (-$b + sqrt($d)) / (2 * $a);
			$x2 = (-$b - sqrt($d)) / (2 * $a);
			return [$x1, $x2];
		} elseif ($d < 0) {
			return [];
		}
		//($d == 0)
		else {
			// Один корень
			$x = -$b / (2 * $a);
			return [$x];
		}
	}
}