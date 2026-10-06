<?php

declare(strict_types=1);

/**
 * Урок 28 — Обработка ошибок.
 *
 * Практика: error_reporting, trigger_error, set_error_handler,
 * ErrorException, register_shutdown_function.
 *
 * Открой в браузере:
 * http://localhost/php-the-right-way/28-error-handling/
 */

// ---------------------------------------------------------------------
// 1. Текущие настройки.
// ---------------------------------------------------------------------

echo '<h3>1. Настройки</h3>';

echo 'error_reporting = ' . error_reporting() . '<br>';
echo 'display_errors = ' . ini_get('display_errors') . '<br>';
echo 'log_errors = ' . ini_get('log_errors') . '<br>';
echo 'error_log = ' . var_export(ini_get('error_log'), true) . '<br>';

// ---------------------------------------------------------------------
// 2. Установка error_reporting.
// ---------------------------------------------------------------------

echo '<h3>2. error_reporting</h3>';

$previous = error_reporting(E_ALL);
echo 'Установлено E_ALL: ' . error_reporting() . '<br>';

// Восстанавливаем.
error_reporting($previous);

// ---------------------------------------------------------------------
// 3. trigger_error (E_USER_NOTICE).
// ---------------------------------------------------------------------

echo '<h3>3. trigger_error</h3>';

trigger_error('Это уведомление', E_USER_NOTICE);
echo 'После E_USER_NOTICE<br>';

trigger_error('Это предупреждение', E_USER_WARNING);
echo 'После E_USER_WARNING<br>';

// E_USER_ERROR — deprecated в PHP 8.4.
if (PHP_VERSION_ID < 80400) {
    // trigger_error('Fatal', E_USER_ERROR);
}

// ---------------------------------------------------------------------
// 4. Пользовательский обработчик.
// ---------------------------------------------------------------------

echo '<h3>4. set_error_handler</h3>';

function customErrorHandler(int $errno, string $errstr, string $errfile, int $errline): bool
{
    $level = match ($errno) {
        E_USER_NOTICE => 'NOTICE',
        E_USER_WARNING => 'WARNING',
        E_USER_DEPRECATED => 'DEPRECATED',
        default => 'UNKNOWN',
    };

    echo "[$level] $errstr in " . basename($errfile) . ":$errline<br>";

    return true;
}

set_error_handler('customErrorHandler', E_ALL);

trigger_error('Обработано пользовательским обработчиком', E_USER_WARNING);
trigger_error('Ещё одно уведомление', E_USER_NOTICE);

// Восстанавливаем.
restore_error_handler();

// ---------------------------------------------------------------------
// 5. ErrorException.
// ---------------------------------------------------------------------

echo '<h3>5. ErrorException</h3>';

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        return false;
    }
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

try {
    trigger_error('Превращено в исключение', E_USER_WARNING);
} catch (ErrorException $e) {
    echo 'Поймано: ' . $e->getMessage() . '<br>';
    echo 'Уровень: ' . $e->getSeverity() . '<br>';
}

restore_error_handler();

// ---------------------------------------------------------------------
// 6. Исключения.
// ---------------------------------------------------------------------

echo '<h3>6. Исключения</h3>';

function divide(int $a, int $b): float
{
    if ($b === 0) {
        throw new InvalidArgumentException('Деление на ноль');
    }
    return $a / $b;
}

try {
    echo divide(10, 2) . '<br>';
    echo divide(10, 0) . '<br>';
} catch (InvalidArgumentException $e) {
    echo 'Исключение: ' . $e->getMessage() . '<br>';
} finally {
    echo 'Блок finally выполнен.<br>';
}

// ---------------------------------------------------------------------
// 7. Ручное логирование.
// ---------------------------------------------------------------------

echo '<h3>7. error_log</h3>';

$logFile = __DIR__ . '/error.log';
error_log('Тестовое сообщение', 3, $logFile);

if (file_exists($logFile)) {
    echo 'Лог записан: ' . htmlspecialchars(file_get_contents($logFile)) . '<br>';
    unlink($logFile);
}

// ---------------------------------------------------------------------
// 8. register_shutdown_function.
// ---------------------------------------------------------------------

echo '<h3>8. Обработка фатальных ошибок</h3>';

register_shutdown_function(function () {
    $error = error_get_last();

    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
        echo '<br><strong>Перехвачена фатальная ошибка:</strong> ';
        echo $error['message'] . ' в ' . $error['file'] . ':' . $error['line'];
    }
});

echo 'Скрипт продолжает работу.<br>';

// ---------------------------------------------------------------------
// 9. @ — подавление ошибок.
// ---------------------------------------------------------------------

echo '<h3>9. Оператор @</h3>';

$value = @file_get_contents('/nonexistent/file.txt');
var_dump($value);   // false, без Warning

// @ не отменяет пользовательский обработчик.
set_error_handler(function ($errno, $errstr) {
    echo "Обработчик: $errstr<br>";
    return true;
});

@trigger_error('С @', E_USER_WARNING);   // Обработчик вызовется

restore_error_handler();

// ---------------------------------------------------------------------
// 10. Сводка.
// ---------------------------------------------------------------------

echo '<h3>10. Сводка</h3>';

echo 'error_reporting() = ' . error_reporting() . '<br>';
echo 'display_errors = ' . ini_get('display_errors') . '<br>';
echo 'PHP version = ' . PHP_VERSION . '<br>';

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;