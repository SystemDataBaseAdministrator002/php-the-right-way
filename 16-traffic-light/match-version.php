<?php

declare(strict_types=1);

function trafficLightMatch(string $color): string {
    return match ($color) {
        'Красный' => 'Стоять',
        'Жёлтый' => 'Приготовиться',
        'Зелёный' => 'Поехали',
        default => 'Ошибка',
    };
}