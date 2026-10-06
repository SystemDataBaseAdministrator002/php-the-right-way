<?php 

declare(strict_types=1);

// Проверка возраста:

$age = 16;
// Если возраст меньше 18 – выведи "Несовершеннолетний", иначе – "Совершеннолетний"

function isAdult(int $age): bool {
    $result = $age >= 18;
    return $result;
}

echo isAdult($age) ? 'Совершеннолетний' : 'Несовершеннолетний';

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;