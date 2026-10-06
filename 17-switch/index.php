<?php

declare(strict_types=1);

/**
 * Урок 17 — Оператор switch.
 *
 * Практика: switch, break, fall-through, continue,
 * альтернативный синтаксис, match.
 *
 * Открой в браузере:
 * http://localhost/php-the-right-way/17-switch/
 */

// ---------------------------------------------------------------------
// 1. Базовый switch.
// ---------------------------------------------------------------------

echo '<h3>1. Базовый switch</h3>';

$status = 'paid';

switch ($status) {
    case 'pending':
        echo 'Ожидает оплаты<br>';
        break;
    case 'paid':
        echo 'Оплачено<br>';
        break;
    case 'refunded':
        echo 'Возврат средств<br>';
        break;
    default:
        echo 'Неизвестный статус<br>';
}

// ---------------------------------------------------------------------
// 2. Fall-through (без break).
// ---------------------------------------------------------------------

echo '<h3>2. Fall-through</h3>';

$x = 1;

switch ($x) {
    case 1:
        echo 'Один';
        // break забыт!
    case 2:
        echo 'Два или больше';
        break;
}
echo '<br>';

// ---------------------------------------------------------------------
// 3. Намеренное fall-through.
// ---------------------------------------------------------------------

echo '<h3>3. Намеренное fall-through</h3>';

$level = 2;

switch ($level) {
    case 1:
    case 2:
        echo 'Начальный уровень<br>';
        break;
    case 3:
    case 4:
        echo 'Средний уровень<br>';
        break;
}

// ---------------------------------------------------------------------
// 4. switch внутри цикла.
// ---------------------------------------------------------------------

echo '<h3>4. switch внутри цикла</h3>';

$items = [
    ['type' => 'normal', 'name' => 'Item 1'],
    ['type' => 'skip',   'name' => 'Item 2'],
    ['type' => 'normal', 'name' => 'Item 3'],
    ['type' => 'stop',   'name' => 'Item 4'],
    ['type' => 'normal', 'name' => 'Item 5'],
];

foreach ($items as $item) {
    switch ($item['type']) {
        case 'skip':
            echo "Пропускаем: {$item['name']} (continue как break)<br>";
            continue;   // Работает как break — выходит из switch, НЕ пропускает итерацию
        case 'stop':
            echo "Останавливаемся на: {$item['name']} (continue 2)<br>";
            continue 2; // Пропускает итерацию foreach
        default:
            echo "Обрабатываем: {$item['name']}<br>";
            break;
    }
    echo "  (после switch для {$item['name']})<br>";
}

// ---------------------------------------------------------------------
// 5. break 2 — выход из switch и цикла.
// ---------------------------------------------------------------------

echo '<h3>5. break 2</h3>';

foreach ($items as $item) {
    switch ($item['type']) {
        case 'stop':
            echo "break 2 на: {$item['name']}<br>";
            break 2;   // Выход из switch И из foreach
        default:
            echo "Обрабатываем: {$item['name']}<br>";
            break;
    }
}
echo 'После цикла.<br>';

// ---------------------------------------------------------------------
// 6. Сравнение switch и if/else.
// ---------------------------------------------------------------------

echo '<h3>6. switch vs if/else</h3>';

$value = '5';

// switch — нестрогое сравнение.
switch ($value) {
    case 5:
        echo "switch: '5' == 5 (true)<br>";
        break;
    default:
        echo "switch: не совпало<br>";
}

// if/else — можно использовать ===.
if ($value === 5) {
    echo "if: '5' === 5 (false)<br>";
} elseif ($value === '5') {
    echo "if: '5' === '5' (true)<br>";
}

// ---------------------------------------------------------------------
// 7. Изменения в PHP 8.0.
// ---------------------------------------------------------------------

echo '<h3>7. PHP 8.0: сравнение строк и чисел</h3>';

$emptyString = '';

switch ($emptyString) {
    case 0:
        echo "PHP 8: '' == 0 → false (не выполнится)<br>";
        break;
    default:
        echo "PHP 8: '' не совпало с 0<br>";
}

// ---------------------------------------------------------------------
// 8. Альтернативный синтаксис.
// ---------------------------------------------------------------------

echo '<h3>8. Альтернативный синтаксис</h3>';

$userStatus = 'paid';
?>

<div class="status">
    <?php switch ($userStatus):
        case 'paid': ?>
            <span class="paid">Оплачено</span>
            <?php break; ?>
        <?php
        case 'pending': ?>
            <span class="pending">Ожидает</span>
            <?php break; ?>
        <?php
        default: ?>
            <span class="unknown">Неизвестно</span>
    <?php endswitch; ?>
</div>

<?php
// ---------------------------------------------------------------------
// 9. match — современная альтернатива.
// ---------------------------------------------------------------------

echo '<h3>9. match (PHP 8.0+)</h3>';

$status = 'paid';

$result = match ($status) {
    'paid'    => 'Оплачено',
    'pending' => 'Ожидает',
    'refunded' => 'Возврат',
    default   => 'Неизвестно',
};

echo 'match: ' . $result . '<br>';

// match использует строгое сравнение.
$value = '5';

$matchResult = match ($value) {
    5       => 'Число 5',
    '5'     => 'Строка "5"',
    default => 'Не совпало',
};

echo 'match со строгим сравнением: ' . $matchResult . '<br>';   // Строка "5"

// ---------------------------------------------------------------------
// 10. Практический пример: обработка HTTP-кодов.
// ---------------------------------------------------------------------

echo '<h3>10. HTTP-коды</h3>';

$httpCodes = [200, 301, 404, 500];

foreach ($httpCodes as $code) {
    switch ($code) {
        case 200:
            $message = 'OK';
            break;
        case 301:
            $message = 'Moved Permanently';
            break;
        case 404:
            $message = 'Not Found';
            break;
        case 500:
            $message = 'Internal Server Error';
            break;
        default:
            $message = 'Unknown';
    }
    echo "HTTP $code: $message<br>";
}

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;