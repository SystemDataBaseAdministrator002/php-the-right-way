<?php

declare(strict_types=1);

// Вывести таблицу умножения для числа N:

$n = 7;
// Выведи таблицу умножения от 1 до 10 для числа $n

function printMultiplicationTable(int $n): void {
    for ($i = 1; $i <= 10; $i++) {
        echo "$n &times; $i = " . ($n * $i) . ';' . '<br>';
    }
}

printMultiplicationTable($n);

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;