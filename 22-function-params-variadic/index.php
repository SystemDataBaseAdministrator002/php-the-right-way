<?php

declare(strict_types=1);

/**
 * Урок 22 — Параметры функций: именованные аргументы,
 * variadic, splat.
 *
 * Практика: значения по умолчанию, variadic, splat,
 * именованные аргументы, ассоциативная распаковка.
 *
 * Открой в браузере:
 * http://localhost/php-the-right-way/22-function-params-variadic/
 */

// ---------------------------------------------------------------------
// 1. Значения по умолчанию.
// ---------------------------------------------------------------------

echo '<h3>1. Значения по умолчанию</h3>';

function greet(string $name, string $greeting = 'Hello'): string
{
    return "$greeting, $name";
}

echo greet('Gio') . '<br>';           // Hello, Gio
echo greet('Gio', 'Hi') . '<br>';     // Hi, Gio

// ---------------------------------------------------------------------
// 2. Вариативные функции.
// ---------------------------------------------------------------------

echo '<h3>2. Вариативные функции</h3>';

function sum(int ...$numbers): int
{
    return array_sum($numbers);
}

echo 'sum(1, 2, 3) = ' . sum(1, 2, 3) . '<br>';           // 6
echo 'sum(10, 20, 30, 40) = ' . sum(10, 20, 30, 40) . '<br>';  // 100

// С фиксированными параметрами.
function logMessage(string $level, ...$messages): string
{
    return "[$level] " . implode(' ', $messages);
}

echo logMessage('INFO', 'User', 'logged', 'in') . '<br>';
// [INFO] User logged in

// Union-типы для variadic (PHP 8.0+).
function process(int|string ...$items): void
{
    foreach ($items as $item) {
        echo get_debug_type($item) . ':' . $item . ' ';
    }
    echo '<br>';
}

process(1, 'two', 3, 'four');

// ---------------------------------------------------------------------
// 3. Splat при вызове функции.
// ---------------------------------------------------------------------

echo '<h3>3. Splat при вызове</h3>';

function multiply(float $a, float $b, float $c): float
{
    return $a * $b * $c;
}

$values = [2, 3, 4];
echo 'multiply(...[2, 3, 4]) = ' . multiply(...$values) . '<br>';   // 24

// Числовые ключи игнорируются.
$assoc = [1 => 2, 5 => 3, 10 => 4];
echo 'multiply(...[1=>2, 5=>3, 10=>4]) = ' . multiply(...$assoc) . '<br>';
// 24

// ---------------------------------------------------------------------
// 4. Splat в литерале массива.
// ---------------------------------------------------------------------

echo '<h3>4. Splat в литерале массива</h3>';

$a = [1, 2];
$b = [3, 4];
$merged = [...$a, ...$b];

echo '<pre>';
print_r($merged);   // [1, 2, 3, 4]
echo '</pre>';

// Ассоциативные ключи (PHP 8.1+).
$defaults = ['color' => 'red', 'size' => 'M'];
$overrides = ['color' => 'blue'];
$config = [...$defaults, ...$overrides];

echo '<pre>';
print_r($config);   // ['color' => 'blue', 'size' => 'M']
echo '</pre>';

// ---------------------------------------------------------------------
// 5. Распаковка генератора.
// ---------------------------------------------------------------------

echo '<h3>5. Распаковка генератора</h3>';

function gen(): Generator
{
    yield 1;
    yield 2;
    yield 3;
}

$list = [...gen()];
echo '<pre>';
print_r($list);   // [1, 2, 3]
echo '</pre>';

// ---------------------------------------------------------------------
// 6. Именованные аргументы (PHP 8.0+).
// ---------------------------------------------------------------------

echo '<h3>6. Именованные аргументы</h3>';

echo greet(name: 'Alice', greeting: 'Hi') . '<br>';
echo greet(greeting: 'Hi', name: 'Alice') . '<br>';   // Порядок не важен

// Практический пример.
function buildCookieString(
    string $name,
    string $value = '',
    int $expires = 0,
    string $path = '/',
    bool $secure = false,
    bool $httpOnly = false
): string {
    return "name=$name, value=$value, expires=$expires, path=$path, secure=" . var_export($secure, true) . ", httpOnly=" . var_export($httpOnly, true);
}

echo buildCookieString(name: 'session', value: 'abc123', httpOnly: true) . '<br>';

// ---------------------------------------------------------------------
// 7. Комбинирование позиционных и именованных.
// ---------------------------------------------------------------------

echo '<h3>7. Позиционные + именованные</h3>';

echo greet('Gio', greeting: 'Hi') . '<br>';   // Hi, Gio

// Нельзя после именованного передать позиционный:
// echo greet(greeting: 'Hi', 'Gio');  // Fatal error

// ---------------------------------------------------------------------
// 8. Распаковка ассоциативного массива в вызов.
// ---------------------------------------------------------------------

echo '<h3>8. Распаковка ассоциативного массива</h3>';

$args = ['name' => 'Alice', 'greeting' => 'Hey'];
echo greet(...$args) . '<br>';   // Hey, Alice

// ---------------------------------------------------------------------
// 9. Сравнение array_merge и splat.
// ---------------------------------------------------------------------

echo '<h3>9. array_merge vs splat</h3>';

$arr1 = [1, 2];
$arr2 = [3, 4];

echo '<pre>';
echo 'array_merge: ';
print_r(array_merge($arr1, $arr2));
echo 'splat:       ';
print_r([...$arr1, ...$arr2]);
echo '</pre>';

// Строковые ключи.
$s1 = ['a' => 1, 'b' => 2];
$s2 = ['b' => 3, 'c' => 4];

echo '<pre>';
echo 'array_merge: ';
print_r(array_merge($s1, $s2));
echo 'splat:       ';
print_r([...$s1, ...$s2]);
echo '</pre>';

// ---------------------------------------------------------------------
// 10. Практический пример: конфиг с defaults.
// ---------------------------------------------------------------------

echo '<h3>10. Конфиг с defaults</h3>';

function createConfig(array $defaults, array $overrides): array
{
    return [...$defaults, ...$overrides];
}

$defaultConfig = [
    'host' => 'localhost',
    'port' => 3306,
    'user' => 'root',
    'debug' => false,
];

$userConfig = [
    'port' => 5432,
    'debug' => true,
];

$config = createConfig($defaultConfig, $userConfig);

echo '<pre>';
print_r($config);
echo '</pre>';

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;