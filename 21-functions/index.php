<?php

declare(strict_types=1);

/**
 * Урок 21 — Создание функций.
 *
 * Практика: объявление, вызов, типы возврата,
 * рекурсия, ссылки, first-class callable, function_exists.
 *
 * Открой в браузере:
 * http://localhost/php-the-right-way/21-functions/
 */

// ---------------------------------------------------------------------
// 1. Простая функция.
// ---------------------------------------------------------------------

echo '<h3>1. Простая функция</h3>';

function greet(): void
{
    echo 'Hello, world!<br>';
}

greet();
greet();

// ---------------------------------------------------------------------
// 2. Функция с параметрами и возвратом.
// ---------------------------------------------------------------------

echo '<h3>2. Параметры и возврат</h3>';

function add(int $a, int $b): int
{
    return $a + $b;
}

echo 'add(2, 3) = ' . add(2, 3) . '<br>';   // 5

// ---------------------------------------------------------------------
// 3. Типы возврата.
// ---------------------------------------------------------------------

echo '<h3>3. Типы возврата</h3>';

function noReturn(): void
{
    echo 'void функция<br>';
}

noReturn();

function nullable(): ?string
{
    return null;
}

var_dump(nullable());   // NULL
echo '<br>';

function union(): int|float
{
    return 1.5;
}

var_dump(union());   // float(1.5)
echo '<br>';

function mixedType(): mixed
{
    return [1, 2, 3];
}

var_dump(mixedType());   // array(3)
echo '<br>';

// never (PHP 8.1+) — раскомментируй для демонстрации:
// function stop(): never { exit; }

// ---------------------------------------------------------------------
// 4. Параметры по умолчанию.
// ---------------------------------------------------------------------

echo '<h3>4. Параметры по умолчанию</h3>';

function greeting(string $name = 'Guest'): string
{
    return "Hello, $name";
}

echo greeting() . '<br>';         // Hello, Guest
echo greeting('Gio') . '<br>';    // Hello, Gio

// ---------------------------------------------------------------------
// 5. Параметры по ссылке.
// ---------------------------------------------------------------------

echo '<h3>5. Параметры по ссылке</h3>';

function increment(int &$value): void
{
    $value++;
}

$count = 5;
increment($count);
echo '$count = ' . $count . '<br>';   // 6

// ---------------------------------------------------------------------
// 6. Рекурсия.
// ---------------------------------------------------------------------

echo '<h3>6. Рекурсия</h3>';

function factorial(int $n): int
{
    if ($n <= 1) {
        return 1;
    }
    return $n * factorial($n - 1);
}

echo 'factorial(5) = ' . factorial(5) . '<br>';   // 120

// ---------------------------------------------------------------------
// 7. Анонимные и стрелочные функции.
// ---------------------------------------------------------------------

echo '<h3>7. Анонимные и стрелочные</h3>';

$double = function ($x) {
    return $x * 2;
};

$triple = fn($x) => $x * 3;

echo '$double(5) = ' . $double(5) . '<br>';   // 10
echo '$triple(5) = ' . $triple(5) . '<br>';   // 15

// ---------------------------------------------------------------------
// 8. First-class callable syntax (PHP 8.1+).
// ---------------------------------------------------------------------

echo '<h3>8. First-class callable</h3>';

$strlen = strlen(...);
echo '$strlen("Hello") = ' . $strlen('Hello') . '<br>';   // 5

$upper = strtoupper(...);
echo '$upper("hello") = ' . $upper('hello') . '<br>';     // HELLO

// ---------------------------------------------------------------------
// 9. Условное определение с function_exists.
// ---------------------------------------------------------------------

echo '<h3>9. Условное определение</h3>';

if (!function_exists('helper')) {
    function helper(): string
    {
        return 'ok';
    }
}

echo 'helper() = ' . helper() . '<br>';

// Повторное объявление невозможно — раскомментируй, увидишь Fatal error:
// function helper(): string { return 'again'; }

// ---------------------------------------------------------------------
// 10. Функция внутри функции.
// ---------------------------------------------------------------------

echo '<h3>10. Функция внутри функции</h3>';

function outer(): void
{
    echo 'Вызвана outer()<br>';

    function inner(): string
    {
        return 'inner';
    }
}

// inner() ещё не определена:
// echo inner();   // Fatal error

outer();
echo 'inner() = ' . inner() . '<br>';   // inner

// Повторный вызов outer() — Fatal error:
// outer();

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;