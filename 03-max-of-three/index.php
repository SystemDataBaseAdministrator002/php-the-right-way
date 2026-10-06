<?php

declare(strict_types=1);

// Наибольшее из трёх чисел:

$a = 12;
$b = 7;
$c = 20;
// Найди и выведи максимальное число

function maxOfThree(int|float $a, int|float $b, int|float $c): int|float {
    if ($a >= $b && $a >= $c) {
        return $a;
    } elseif ($b >= $c) {
        return $b;
    } else { 
        return $c;
    }
}

echo maxOfThree($a, $b, $c);

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;
