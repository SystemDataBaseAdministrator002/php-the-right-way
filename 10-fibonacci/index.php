<?php

declare(strict_types=1);

// Числа Фибоначчи:

$n = 10;
// Выведи первые 10 чисел Фибоначчи: 0, 1, 1, 2, 3, 5, 8, ...

function getFibonacci(int $n): array {
    if ($n <= 0) {
        return [];
    }

    if ($n === 1) {
        return [0];
    }

    $sequence = [0, 1];

    for ($i = 2; $i < $n; $i++) {
        $sequence[] = $sequence[$i - 1] + $sequence[$i - 2];
    }

    return $sequence;
}

print_r(getFibonacci($n));

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;