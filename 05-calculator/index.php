<?php

declare(strict_types=1);

// Калькулятор:

$a = 10;
$b = 5;
$operator = '+';    // Возможные значения: '+', '-', '*', '/'
// В зависимости от оператора выведи результат операции $a и $b

function calculator(int|float $a, int|float $b, string $operator): int|float|string {
    switch ($operator) {
        case '+':
            return $a + $b;
        case '-':
            return $a - $b;
        case '*':
            return $a * $b;
        case '/':
            return $b == 0 ? 'Деление на ноль невозможно' : $a / $b;
        default:
            return "Неизвестный оператор";
    }
}

echo calculator(a: $a, b: $b, operator: $operator);

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;