<?php

declare(strict_types=1);

// Факториал числа (n!):

$n = 5;
// Вычисли 5! = 5 * 4 * 3 * 2 * 1

function calculateFactorial(int $n): int|float {
    $result = 1;
    for ($i = 1; $i <= $n; $i++) {
        $result *= $i;
    }
    return $result;
}

echo calculateFactorial($n);

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;
