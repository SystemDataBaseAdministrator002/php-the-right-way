<?php

declare(strict_types=1);

// Вывести числа от 1 до 10, используя for или while:

function outputNumbersViaFor(int $number): void {
    for ($i = 1; $i <= $number; $i++) {
        echo "{$i}" . " ";
    }
}

outputNumbersViaFor(number: 10); 

echo '<br>';

function outputNumbersViaWhile(int $number): void {
    $i = 1;

    while ($i < $number) {
        $i++;
        echo "{$i}" . " ";
    }
}

outputNumbersViaWhile(number:10);

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;