<?php

declare(strict_types=1);

// Сумма всех элементов массива:

$arr = [2, 4, 6, 8];
// Найди сумму всех чисел в массиве

function arraySum(array $arr): int|float
{
    $sum = 0;

    foreach ($arr as $number) {
        $sum += $number;
    }

    return $sum;
}

echo arraySum($arr);

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;