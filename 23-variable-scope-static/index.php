<?php

declare(strict_types=1);

/**
 * Урок 23 — Области видимости и статические переменные.
 *
 * Практика: глобальная/локальная область, global, $GLOBALS,
 * параметры, static переменные.
 *
 * Открой в браузере:
 * http://localhost/php-the-right-way/23-variable-scope-static/
 */

// ---------------------------------------------------------------------
// 1. Глобальная и локальная область.
// ---------------------------------------------------------------------

echo '<h3>1. Области видимости</h3>';

$globalVar = 'Я глобальная';

function testLocal(): void
{
    $localVar = 'Я локальная';
    echo $localVar . '<br>';

    // $globalVar здесь недоступна:
    // echo $globalVar;   // Warning: Undefined variable
}

testLocal();
echo $globalVar . '<br>';

// ---------------------------------------------------------------------
// 2. global.
// ---------------------------------------------------------------------

echo '<h3>2. global</h3>';

$name = 'Tom';

function helloGlobal(): void
{
    global $name;
    echo "Hello, $name<br>";
}

helloGlobal();   // Hello, Tom

// Изменение глобальной переменной.
function changeGlobal(): void
{
    global $name;
    $name = 'Tomas';
}

changeGlobal();
echo "После changeGlobal: $name<br>";   // Tomas

// Несколько переменных.
$age = 30;

function showInfo(): void
{
    global $name, $age;
    echo "$name is $age<br>";
}

showInfo();   // Tomas is 30

// ---------------------------------------------------------------------
// 3. $GLOBALS.
// ---------------------------------------------------------------------

echo '<h3>3. $GLOBALS</h3>';

$city = 'Moscow';

function changeCity(): void
{
    $old = $GLOBALS['city'];
    echo "Старый город: $old<br>";

    $GLOBALS['city'] = 'Saint Petersburg';
}

changeCity();
echo "Новый город: $city<br>";   // Saint Petersburg

// Проверка существования.
if (isset($GLOBALS['city'])) {
    echo 'Город существует в $GLOBALS<br>';
}

// ---------------------------------------------------------------------
// 4. Передача через параметры.
// ---------------------------------------------------------------------

echo '<h3>4. Параметры</h3>';

$userName = 'Alice';

function greetUser(string $userName): void
{
    echo "Hello, $userName<br>";
}

greetUser($userName);   // Hello, Alice

// ---------------------------------------------------------------------
// 5. Статические переменные.
// ---------------------------------------------------------------------

echo '<h3>5. Статические переменные</h3>';

function counter(): int
{
    static $count = 0;
    $count++;
    return $count;
}

echo counter() . '<br>';   // 1
echo counter() . '<br>';   // 2
echo counter() . '<br>';   // 3

// Без static — сбрасывается.
function nonStaticCounter(): int
{
    $count = 0;
    $count++;
    return $count;
}

echo nonStaticCounter() . '<br>';   // 1
echo nonStaticCounter() . '<br>';   // 1

// ---------------------------------------------------------------------
// 6. Кэширование через static.
// ---------------------------------------------------------------------

echo '<h3>6. Кэширование</h3>';

function expensiveOperation(): string
{
    static $cache = null;

    if ($cache === null) {
        // Имитация дорогой операции.
        $cache = 'Результат вычислений';
        echo 'Вычисление выполнено.<br>';
    } else {
        echo 'Взято из кэша.<br>';
    }

    return $cache;
}

echo expensiveOperation() . '<br>';   // Вычисление + результат
echo expensiveOperation() . '<br>';   // Из кэша

// ---------------------------------------------------------------------
// 7. Статическая переменная с рекурсией.
// ---------------------------------------------------------------------

echo '<h3>7. static в рекурсии</h3>';

function factorial(int $n): int
{
    static $depth = 0;
    $depth++;

    echo str_repeat('  ', $depth) . "factorial($n)<br>";

    if ($n <= 1) {
        $depth--;
        return 1;
    }

    $result = $n * factorial($n - 1);
    $depth--;
    return $result;
}

echo 'factorial(4) = ' . factorial(4) . '<br>';

// ---------------------------------------------------------------------
// 8. include внутри функции.
// ---------------------------------------------------------------------

echo '<h3>8. include внутри функции</h3>';

$globalMessage = 'Глобальное сообщение';

file_put_contents(
    __DIR__ . '/scope_include.php',
    <<<'PHP'
<?php
echo 'В подключаемом файле: ';
echo $globalMessage ?? 'переменная недоступна';
echo '<br>';
PHP
);

function testInclude(): void
{
    $globalMessage = 'Локальное сообщение';
    include __DIR__ . '/scope_include.php';
}

testInclude();   // Локальное сообщение

unlink(__DIR__ . '/scope_include.php');

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;