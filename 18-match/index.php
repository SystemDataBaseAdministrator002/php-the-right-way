<?php

declare(strict_types=1);

/**
 * Урок 18 — Выражение match.
 *
 * Практика: match, строгое сравнение, объединение условий,
 * UnhandledMatchError, default, match с enum.
 *
 * Открой в браузере:
 * http://localhost/php-the-right-way/18-match/
 */

// ---------------------------------------------------------------------
// 1. Базовый match.
// ---------------------------------------------------------------------

echo '<h3>1. Базовый match</h3>';

$status = 'paid';

$result = match ($status) {
    'paid'    => 'Оплачено',
    'pending' => 'Ожидает',
    'refunded' => 'Возврат',
    default   => 'Неизвестно',
};

echo "Статус: $result<br>";

// ---------------------------------------------------------------------
// 2. Строгое сравнение.
// ---------------------------------------------------------------------

echo '<h3>2. Строгое сравнение</h3>';

$value = '1';

$result = match ($value) {
    1       => 'Число 1',
    '1'     => 'Строка "1"',
    default => 'Не совпало',
};

echo "value = '$value' &rarr; $result<br>";   // Строка "1"

$value = 1;

$result = match ($value) {
    1       => 'Число 1',
    '1'     => 'Строка "1"',
    default => 'Не совпало',
};

echo "value = $value → $result<br>";     // Число 1

// ---------------------------------------------------------------------
// 3. Объединение условий.
// ---------------------------------------------------------------------

echo '<h3>3. Объединение условий</h3>';

$number = 4;

$size = match ($number) {
    1, 2, 3 => 'маленькое',
    4, 5    => 'среднее',
    default => 'большое',
};

echo "Число $number: $size<br>";   // среднее

// ---------------------------------------------------------------------
// 4. match в выражении.
// ---------------------------------------------------------------------

echo '<h3>4. match в выражении</h3>';

$code = 404;

echo 'HTTP ' . $code . ': ' . match ($code) {
    200 => 'OK',
    301 => 'Moved Permanently',
    404 => 'Not Found',
    500 => 'Internal Server Error',
    default => 'Unknown',
} . '<br>';

// ---------------------------------------------------------------------
// 5. UnhandledMatchError.
// ---------------------------------------------------------------------

echo '<h3>5. UnhandledMatchError</h3>';

$value = 3;

try {
    $result = match ($value) {
        1 => 'one',
        2 => 'two',
    };
    echo "Результат: $result<br>";
} catch (UnhandledMatchError $e) {
    echo 'UnhandledMatchError: ' . $e->getMessage() . '<br>';
}

// С default:
$result = match ($value) {
    1 => 'one',
    2 => 'two',
    default => 'unknown',
};
echo "С default: $result<br>";

// ---------------------------------------------------------------------
// 6. default с выбросом исключения.
// ---------------------------------------------------------------------

echo '<h3>6. default с исключением</h3>';

$code = 999;

try {
    $status = match ($code) {
        200 => 'ok',
        404 => 'not found',
        default => throw new InvalidArgumentException("Unknown status code: $code"),
    };
    echo "Статус: $status<br>";
} catch (InvalidArgumentException $e) {
    echo 'Исключение: ' . $e->getMessage() . '<br>';
}

// ---------------------------------------------------------------------
// 7. match с разными типами возврата.
// ---------------------------------------------------------------------

echo '<h3>7. Разные типы возврата</h3>';

$type = 'array';

$result = match ($type) {
    'array'  => [1, 2, 3],
    'object' => new stdClass(),
    'null'   => null,
    default  => 'string',
};

echo 'Тип: ' . get_debug_type($result) . '<br>';

// ---------------------------------------------------------------------
// 8. match с enum (PHP 8.1+).
// ---------------------------------------------------------------------

echo '<h3>8. match с enum</h3>';

enum Status: string
{
    case Paid = 'paid';
    case Pending = 'pending';
    case Refunded = 'refunded';
}

$currentStatus = Status::Paid;

$label = match ($currentStatus) {
    Status::Paid     => 'Оплачено',
    Status::Pending  => 'Ожидает',
    Status::Refunded => 'Возврат',
};

echo "Статус: $label<br>";

// ---------------------------------------------------------------------
// 9. match vs switch.
// ---------------------------------------------------------------------

echo '<h3>9. match vs switch</h3>';

$value = '5';

// switch — нестрогое сравнение.
switch ($value) {
    case 5:
        echo "switch: '5' == 5 → совпало<br>";
        break;
    default:
        echo "switch: не совпало<br>";
}

// match — строгое сравнение.
$result = match ($value) {
    5       => "match: '5' === 5 → совпало",
    '5'     => "match: '5' === '5' → совпало",
    default => "match: не совпало",
};

echo $result . '<br>';

// ---------------------------------------------------------------------
// 10. Практический пример: обработка статусов заказа.
// ---------------------------------------------------------------------

echo '<h3>10. Статусы заказа</h3>';

$orders = [
    ['id' => 1, 'status' => 'paid'],
    ['id' => 2, 'status' => 'pending'],
    ['id' => 3, 'status' => 'shipped'],
    ['id' => 4, 'status' => 'unknown'],
];

foreach ($orders as $order) {
    $message = match ($order['status']) {
        'paid'    => 'Заказ оплачен',
        'pending' => 'Ожидает оплаты',
        'shipped' => 'Отправлен',
        default   => 'Статус неизвестен',
    };

    echo "Заказ #{$order['id']}: $message<br>";
}

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;