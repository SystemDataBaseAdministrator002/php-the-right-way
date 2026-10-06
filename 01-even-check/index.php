<?php

declare(strict_types=1);

//Проверка на чётность:

$n = 7;
//Выведи "Чётное", если число чётное, иначе "Нечётное"

function isEven(int $n): bool {
    $result = ($n % 2 === 0);
    return $result;
}

echo isEven($n) ? 'Чётное' : 'Нечётное';

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;