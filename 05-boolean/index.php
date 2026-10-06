<?php

declare(strict_types=1);

/**
 * Урок 05 — Логический тип (Boolean).
 *
 * Практика: создание bool, приведение типов к bool,
 * вывод bool, is_bool, преобразование в строку.
 *
 * Открой в браузере:
 * http://localhost/php-the-right-way/05-boolean/
 */

// ---------------------------------------------------------------------
// 1. Создание логических переменных.
// ---------------------------------------------------------------------

$isPaid    = true;
$isCancelled = false;

echo '<h3>1. Создание bool</h3>';
var_dump($isPaid);       // bool(true)
var_dump($isCancelled);  // bool(false)
echo '<br>';

// ---------------------------------------------------------------------
// 2. Приведение различных типов к bool.
// false: false, 0, 0.0, -0.0, "", "0", [], null.
// true: всё остальное.
// ---------------------------------------------------------------------

echo '<h3>2. Приведение к bool</h3>';
echo '<pre>';

$values = [
    'false (bool)'      => false,
    '0 (int)'           => 0,
    '-0 (int)'          => -0,
    '0.0 (float)'       => 0.0,
    '-0.0 (float)'      => -0.0,
    '"" (string)'       => '',
    '"0" (string)'      => '0',
    '[] (array)'        => [],
    'null'              => null,
    '1 (int)'           => 1,
    '-1 (int)'          => -1,
    '"false" (string)'  => 'false',
    '"0.0" (string)'    => '0.0',
    'NAN'               => NAN,
];

foreach ($values as $label => $value) {
    printf(
        "%-20s → %s\n",
        $label,
        var_export((bool) $value, true)
    );
}

echo '</pre>';

// ---------------------------------------------------------------------
// 3. Вывод bool через echo.
// true → "1", false → "".
// ---------------------------------------------------------------------

echo '<h3>3. Вывод через echo</h3>';
echo 'true: ';
echo true;          // 1
echo '<br>';
echo 'false: ';
echo false;         // (ничего)
echo '<br>';

// ---------------------------------------------------------------------
// 4. Проверка типа через is_bool.
// ---------------------------------------------------------------------

echo '<h3>4. is_bool</h3>';
var_dump(is_bool(true));    // bool(true)
var_dump(is_bool(1));       // bool(false)
var_dump(is_bool('true'));  // bool(false)
echo '<br>';

// ---------------------------------------------------------------------
// 5. Особенность строки "false".
// ---------------------------------------------------------------------

echo '<h3>5. Строка "false"</h3>';
var_dump((bool) 'false');   // bool(true)
var_dump((bool) '');        // bool(false)
var_dump((bool) '0');       // bool(false)
var_dump((bool) '0.0');     // bool(true)
echo '<br>';

// ---------------------------------------------------------------------
// 6. Преобразование bool в строку.
// ---------------------------------------------------------------------

echo '<h3>6. Bool → строка</h3>';

$bool = true;

echo '(string): '       . (string) $bool . '<br>';                // 1
echo 'strval(): '       . strval($bool) . '<br>';                 // 1
echo 'var_export(): '   . var_export($bool, true) . '<br>';       // true
echo 'json_encode(): '  . json_encode($bool) . '<br>';            // true
echo 'тернарный: '      . ($bool ? 'true' : 'false') . '<br>';    // true
echo 'match: '          . match ($bool) {
    true => 'true',
    false => 'false'
} . '<br>';

// ---------------------------------------------------------------------
// 7. Преобразование строк в bool через filter_var.
// ---------------------------------------------------------------------

echo '<h3>7. filter_var</h3>';
echo '<pre>';

foreach (['true', 'false', 'on', 'off', 'yes', 'no', '1', '0', 'something'] as $str) {
    printf(
        "%-10s → %s\n",
        $str,
        var_export(filter_var($str, FILTER_VALIDATE_BOOLEAN), true)
    );
}

echo '</pre>';

// ---------------------------------------------------------------------
// 8. Двойное отрицание как приведение к bool.
// ---------------------------------------------------------------------

echo '<h3>8. Двойное отрицание</h3>';
$value = 'some string';
var_dump(!!$value);   // bool(true)
echo '<br>';

// ---------------------------------------------------------------------
// 9. Использование в условиях.
// ---------------------------------------------------------------------

echo '<h3>9. В условиях</h3>';

if ($isPaid) {
    echo 'Заказ оплачен.';
} else {
    echo 'Заказ не оплачен.';
}

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;