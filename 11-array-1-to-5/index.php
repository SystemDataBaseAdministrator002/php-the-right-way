<?php

declare(strict_types=1);

// Создать массив чисел от 1 до 5 и вывести их:

$arr = [1, 2, 3, 4, 5];
// Выведи все элементы массива

function joinArray(array $arr): string {
    return implode(' ', $arr);
}

echo joinArray($arr);

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;