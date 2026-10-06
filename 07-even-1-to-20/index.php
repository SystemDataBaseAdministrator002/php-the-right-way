<?php

declare(strict_types=1);

// Вывести только чётные числа от 1 до 20, используя for + if:

function evenNumbersUpTo(int $number): void {
    for ($i = 1; $i <= $number; $i++) {
        echo $i % 2 == 0 ? "{$i}" . " " : false;
    }
}

evenNumbersUpTo(number: 20);

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;