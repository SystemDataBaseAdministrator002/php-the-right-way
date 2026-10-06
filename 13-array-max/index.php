<?php

declare(strict_types=1);

// Найти максимальный элемент в массиве

$arr = [15, 3, 27, 8, 19];
// Найди и выведи максимальное число

function findMax(array $arr): int|float
{
    $max = $arr[0];

    foreach ($arr as $number) {
        if ($number > $max) {
            $max = $number;
        }
    }

    return $max;
}

echo findMax($arr);

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;