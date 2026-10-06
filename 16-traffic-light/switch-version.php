<?php

declare(strict_types=1);

function trafficLightSwitch(string $color): string {
    switch ($color) {
        case 'Красный':
            return 'Стоять';
        case 'Жёлтый':
            return 'Приготовиться';
        case 'Зелёный':
            return 'Поехали';
        default:
            return 'Ошибка';
    }
}