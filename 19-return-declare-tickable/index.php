<?php

declare(strict_types=1);

/**
 * Урок 19 — Оператор return и директива declare.
 *
 * Практика: return в функции и файле, strict_types,
 * encoding, ticks (устарели).
 *
 * Открой в браузере:
 * http://localhost/php-the-right-way/19-return-declare-tickable/
 */

// ---------------------------------------------------------------------
// 1. return внутри функции.
// ---------------------------------------------------------------------

echo '<h3>1. return в функции</h3>';

function add(int $a, int $b): int
{
    return $a + $b;
    // Код после return не выполнится
}

echo 'add(2, 3) = ' . add(2, 3) . '<br>';   // 5

function doNothing()
{
    return;
}

var_dump(doNothing());   // NULL
echo '<br>';

// ---------------------------------------------------------------------
// 2. return вне функции (главный скрипт).
// ---------------------------------------------------------------------

echo '<h3>2. return вне функции</h3>';
echo 'Этот текст выполнится.<br>';

// Раскомментируй — скрипт завершится:
// return;
// echo 'Этот текст не выполнится.';

// ---------------------------------------------------------------------
// 3. return в include.
// ---------------------------------------------------------------------

echo '<h3>3. return в include</h3>';

// Создаём временный файл.
$helperFile = __DIR__ . '/helper.php';
file_put_contents(
    $helperFile,
    <<<'PHP'
<?php
echo "Начало helper.php<br>";
return ['status' => 'ok', 'code' => 200];
echo "Эта строка не выполнится<br>";
PHP
);

$result = include $helperFile;
echo 'Результат include: ' . $result['status'] . ' (' . $result['code'] . ')<br>';

unlink($helperFile);   // Удаляем временный файл

// ---------------------------------------------------------------------
// 4. declare(strict_types=1).
// ---------------------------------------------------------------------

echo '<h3>4. strict_types</h3>';

function multiply(int $a, int $b): int
{
    return $a * $b;
}

echo 'multiply(3, 4) = ' . multiply(3, 4) . '<br>';

// Раскомментируй — получишь TypeError:
// multiply("3", 4);

// ---------------------------------------------------------------------
// 5. declare с блоком (ticks — устарели).
// ---------------------------------------------------------------------

echo '<h3>5. ticks (устарели)</h3>';
echo 'ticks объявлены устаревшими с PHP 5.3 и планируются к удалению в PHP 9.0.<br>';

// Демонстрация (работает, но не рекомендуется).
function tickHandler(): void
{
    echo 'Tick!<br>';
}

// Раскомментируй для демонстрации:
// register_tick_function('tickHandler');
// declare(ticks=1);
// $a = 1;
// $b = 2;
// echo $a + $b;

// ---------------------------------------------------------------------
// 6. encoding.
// ---------------------------------------------------------------------

echo '<h3>6. encoding</h3>';
echo 'Директива encoding почти не используется в современном PHP.<br>';

// ---------------------------------------------------------------------
// 7. Практический пример: конфигурационный файл.
// ---------------------------------------------------------------------

echo '<h3>7. Конфигурация через return</h3>';

$configFile = __DIR__ . '/config.php';
file_put_contents(
    $configFile,
    <<<'PHP'
<?php
return [
    'db_host' => 'localhost',
    'db_name' => 'app',
    'db_user' => 'root',
];
PHP
);

$config = include $configFile;
echo 'DB Host: ' . $config['db_host'] . '<br>';
echo 'DB Name: ' . $config['db_name'] . '<br>';

unlink($configFile);   // Удаляем временный файл

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;