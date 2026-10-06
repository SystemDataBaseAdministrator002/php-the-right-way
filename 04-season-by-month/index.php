<?php

declare(strict_types=1);

// Определение сезона по месяцу:

$month = 3;
// Выведи "Зима", "Весна", "Лето" или "Осень" в зависимости от номера месяца

function getSeasonByMonth(int $month): string {
    switch ($month) {
        case 12:
        case 1:
        case 2:
            return "Зима";
        case 3:
        case 4:
        case 5:
            return "Весна";
        case 6:
        case 7:
        case 8:
            return "Лето";
        case 9:
        case 10:
        case 11:
            return "Осень";
        default:
            return "Неправильный номер месяца";
    }
}

echo getSeasonByMonth($month);

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;