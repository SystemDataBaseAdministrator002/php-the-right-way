<?php

declare(strict_types=1);

require_once(__DIR__ . 'if-version.php');
require_once(__DIR__ . 'switch-version.php');
require_once(__DIR__ . 'match-version.php');

// Светофор (реши через if, switch и match то есть должно быть 3 варианта решения):

$color = 'Красный';
// Если красный - выведи "Стоять"
// Если желтый - выведи "Приготовиться"
// Если зелёный - выведи "Поехали"
// Иначе выведи "Ошибка"

echo trafficLightIf($color), '<br>';
echo trafficLightSwitch($color), '<br>';
echo trafficLightMatch($color), '<br>';

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;