<?php

declare(strict_types=1);

/**
 * Урок 07 — Числа с плавающей запятой (Float).
 *
 * Практика: создание float, точность, особые значения,
 * сравнение float, константы диапазона.
 *
 * Открой в браузере:
 * http://localhost/php-the-right-way/07-float/
 */

// ---------------------------------------------------------------------
// 1. Создание float.
// ---------------------------------------------------------------------

$simple = 3.14;
$exponential = 1.2e3;     // 1200.0
$negativeExp = 7E-10;     // 0.0000000007
$underscored = 1_234.567; // PHP 7.4+

echo '<h3>1. Создание float</h3>';
var_dump($simple, $exponential, $negativeExp, $underscored);
echo '<br>';

// ---------------------------------------------------------------------
// 2. Константы диапазона.
// ---------------------------------------------------------------------

echo '<h3>2. Константы диапазона</h3>';
echo 'PHP_FLOAT_MAX = ' . PHP_FLOAT_MAX . '<br>';
echo 'PHP_FLOAT_MIN = ' . PHP_FLOAT_MIN . '<br>';
echo 'PHP_FLOAT_DIG = ' . PHP_FLOAT_DIG . '<br>';
echo 'PHP_FLOAT_EPSILON = ' . PHP_FLOAT_EPSILON . '<br>';

// ---------------------------------------------------------------------
// 3. Проблема точности.
// ---------------------------------------------------------------------

echo '<h3>3. Проблема точности</h3>';

var_dump(0.1 + 0.7);                // float(0.7999999999999999)
var_dump(floor((0.1 + 0.7) * 10));  // float(7), а не 8!
var_dump(0.1 + 0.2 === 0.3);        // bool(false)

echo '<br>';

// ---------------------------------------------------------------------
// 4. Правильное сравнение float.
// ---------------------------------------------------------------------

echo '<h3>4. Правильное сравнение</h3>';

function floatsAreEqual(float $a, float $b, float $epsilon = PHP_FLOAT_EPSILON): bool
{
    return abs($a - $b) < $epsilon;
}

var_dump(floatsAreEqual(0.1 + 0.2, 0.3)); // bool(true)
var_dump(0.1 + 0.2 === 0.3);             // bool(false)

echo '<br>';

// ---------------------------------------------------------------------
// 5. Особые значения: INF, -INF, NAN.
// ---------------------------------------------------------------------

echo '<h3>5. Особые значения</h3>';
echo '<pre>';

$inf = PHP_FLOAT_MAX * 2;
$negInf = -PHP_FLOAT_MAX * 2;
$nan = acos(2);

var_dump($inf);     // float(INF)
var_dump($negInf);  // float(-INF)
var_dump($nan);     // float(NAN)

echo '</pre>';

// ---------------------------------------------------------------------
// 6. Функции проверки.
// ---------------------------------------------------------------------

echo '<h3>6. Функции проверки</h3>';
echo '<pre>';

var_dump(is_finite(42.0));     // bool(true)
var_dump(is_finite($inf));     // bool(false)
var_dump(is_infinite($inf));   // bool(true)
var_dump(is_infinite(-42.0));  // bool(false)
var_dump(is_nan($nan));        // bool(true)
var_dump(is_nan(42.0));        // bool(false)

echo '</pre>';

// ---------------------------------------------------------------------
// 7. NAN не равно самому себе.
// ---------------------------------------------------------------------

echo '<h3>7. NAN !== NAN</h3>';
var_dump(NAN === NAN);   // bool(false)
var_dump(NAN == NAN);    // bool(false)
echo '<br>';

// ---------------------------------------------------------------------
// 8. Преобразование в float.
// ---------------------------------------------------------------------

echo '<h3>8. Преобразование в float</h3>';
echo '<pre>';

var_dump((float) 42);              // float(42)
var_dump((float) "12.5");          // float(12.5)
var_dump((float) "12.5abc");       // float(12.5)
var_dump((float) "abc");           // float(0)
var_dump(floatval('122.34343The')); // float(122.34343)
var_dump(floatval('The122.34343')); // float(0)

echo '</pre>';

// ---------------------------------------------------------------------
// 9. Преобразование float в int (PHP 8.1+ deprecation).
// ---------------------------------------------------------------------

echo '<h3>9. Float &rarr; int</h3>';
echo '<pre>';

$float = 10.5;

// Явное приведение — работает без предупреждений.
var_dump((int) $float);   // int(10)

// Неявное преобразование (например, в array-ключе) вызывает deprecation notice.
// Раскомментируй — увидишь предупреждение:
$array = [$float => 'value'];   # Без declare(strict_types=1) этого deprecation не увидеть (в PHP 8.1+ deprecation возникает и без strict_types)

echo '</pre>';

// ---------------------------------------------------------------------
// 10. Float в строку.
// ---------------------------------------------------------------------

echo '<h3>10. Float &rarr; строка</h3>';
$num = 123.456789;
echo 'Стандартно: ' . $num . '<br>';
echo 'С 2 знаками: ' . number_format($num, 2) . '<br>';
echo 'sprintf: ' . sprintf('%.3f', $num) . '<br>';

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;