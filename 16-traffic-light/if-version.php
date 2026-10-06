<?php

declare(strict_types=1);

function trafficLightIf(string $color): string {
    if ($color === 'Красный') {
        return 'Стоять';
    } elseif ($color === 'Жёлтый') {
        return 'Приготовиться';
    } elseif ($color === 'Зелёный') {
        return 'Поехали';
    } else {
        return 'Ошибка';
    }
}