<?php

declare(strict_types=1);

/**
 * Урок 27 — Конфигурация PHP: php.ini.
 *
 * Практика: ini_get, ini_set, диагностика, ключевые директивы.
 *
 * Открой в браузере:
 * http://localhost/php-the-right-way/27-php-ini/
 */

// ---------------------------------------------------------------------
// 1. Расположение php.ini.
// ---------------------------------------------------------------------

echo '<h3>1. Расположение php.ini</h3>';

echo 'Loaded Configuration File: ' . (php_ini_loaded_file() ?: 'не найден') . '<br>';
echo 'Scanned Files: ' . (php_ini_scanned_files() ?: 'нет') . '<br>';

// ---------------------------------------------------------------------
// 2. ini_get — чтение директив.
// ---------------------------------------------------------------------

echo '<h3>2. ini_get</h3>';

$directives = [
    'memory_limit',
    'max_execution_time',
    'upload_max_filesize',
    'post_max_size',
    'error_reporting',
    'display_errors',
    'log_errors',
    'date.timezone',
    'include_path',
];

echo '<pre>';
foreach ($directives as $name) {
    $value = ini_get($name);
    printf("%-25s = %s\n", $name, var_export($value, true));
}
echo '</pre>';

// ---------------------------------------------------------------------
// 3. ini_get_all — все директивы.
// ---------------------------------------------------------------------

echo '<h3>3. ini_get_all (ограниченно)</h3>';

$all = ini_get_all(null, false);
echo 'Всего директив: ' . count($all) . '<br>';

// ---------------------------------------------------------------------
// 4. ini_set — изменение в рантайме.
// ---------------------------------------------------------------------

echo '<h3>4. ini_set</h3>';

echo 'До: memory_limit = ' . ini_get('memory_limit') . '<br>';

$old = ini_set('memory_limit', '256M');
if ($old === false) {
    echo 'Не удалось изменить memory_limit<br>';
} else {
    echo 'Старое значение: ' . $old . '<br>';
    echo 'Новое значение: ' . ini_get('memory_limit') . '<br>';
}

// ---------------------------------------------------------------------
// 5. Проверка PHP_INI_SYSTEM.
// ---------------------------------------------------------------------

echo '<h3>5. PHP_INI_SYSTEM</h3>';

// Пример директивы PHP_INI_SYSTEM (не изменится через ini_set).
$old = ini_set('post_max_size', '100M');

if ($old === false) {
    echo 'post_max_size — PHP_INI_SYSTEM, изменить нельзя.<br>';
} else {
    echo 'post_max_size изменён: ' . $old . ' → ' . ini_get('post_max_size') . '<br>';
}

// ---------------------------------------------------------------------
// 6. error_reporting.
// ---------------------------------------------------------------------

echo '<h3>6. error_reporting</h3>';

echo 'Текущий уровень: ' . error_reporting() . '<br>';
echo 'E_ALL = ' . E_ALL . '<br>';

// Временно устанавливаем E_ALL.
$previous = error_reporting(E_ALL);
echo 'После error_reporting(E_ALL): ' . error_reporting() . '<br>';

// Восстанавливаем.
error_reporting($previous);

// ---------------------------------------------------------------------
// 7. display_errors.
// ---------------------------------------------------------------------

echo '<h3>7. display_errors</h3>';

echo 'display_errors = ' . var_export(ini_get('display_errors'), true) . '<br>';
echo 'log_errors = ' . var_export(ini_get('log_errors'), true) . '<br>';
echo 'error_log = ' . var_export(ini_get('error_log'), true) . '<br>';

// ---------------------------------------------------------------------
// 8. Проверка загрузки файлов.
// ---------------------------------------------------------------------

echo '<h3>8. Загрузка файлов</h3>';

echo 'file_uploads = ' . var_export(ini_get('file_uploads'), true) . '<br>';
echo 'upload_max_filesize = ' . ini_get('upload_max_filesize') . '<br>';
echo 'post_max_size = ' . ini_get('post_max_size') . '<br>';
echo 'max_file_uploads = ' . ini_get('max_file_uploads') . '<br>';
echo 'upload_tmp_dir = ' . var_export(ini_get('upload_tmp_dir'), true) . '<br>';

// ---------------------------------------------------------------------
// 9. OPcache.
// ---------------------------------------------------------------------

echo '<h3>9. OPcache</h3>';

if (function_exists('opcache_get_status')) {
    $status = opcache_get_status(false);
    if ($status) {
        echo 'OPcache включён.<br>';
        echo 'Использовано памяти: ' . round($status['memory_usage']['used_memory'] / 1024 / 1024, 2) . ' MB<br>';
        echo 'Свободно: ' . round($status['memory_usage']['free_memory'] / 1024 / 1024, 2) . ' MB<br>';
        echo 'Закэшировано скриптов: ' . $status['opcache_statistics']['num_cached_scripts'] . '<br>';
        echo 'Hit rate: ' . round($status['opcache_statistics']['opcache_hit_rate'], 2) . '%<br>';
    } else {
        echo 'OPcache отключён.<br>';
    }
} else {
    echo 'Расширение OPcache не установлено.<br>';
}

// ---------------------------------------------------------------------
// 10. Часовой пояс.
// ---------------------------------------------------------------------

echo '<h3>10. Часовой пояс</h3>';

echo 'date.timezone = ' . ini_get('date.timezone') . '<br>';
echo 'Текущий пояс: ' . date_default_timezone_get() . '<br>';

// ---------------------------------------------------------------------
// 11. Безопасность.
// ---------------------------------------------------------------------

echo '<h3>11. Безопасность</h3>';

$securityDirectives = [
    'expose_php',
    'allow_url_fopen',
    'allow_url_include',
    'open_basedir',
    'disable_functions',
    'session.cookie_httponly',
    'session.cookie_secure',
];

echo '<pre>';
foreach ($securityDirectives as $name) {
    printf("%-30s = %s\n", $name, var_export(ini_get($name), true));
}
echo '</pre>';

// ---------------------------------------------------------------------
// 12. Рекомендации для разработки.
// ---------------------------------------------------------------------

echo '<h3>12. Рекомендации</h3>';

echo 'Для разработки:<br>';
echo '- error_reporting = E_ALL<br>';
echo '- display_errors = On<br>';
echo '- log_errors = On<br>';
echo '- zend.assertions = 1<br>';
echo '<br>';
echo 'Для продакшена:<br>';
echo '- error_reporting = E_ALL & ~E_DEPRECATED<br>';
echo '- display_errors = Off<br>';
echo '- log_errors = On<br>';
echo '- zend.assertions = -1<br>';
echo '- opcache.enable = 1<br>';

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;