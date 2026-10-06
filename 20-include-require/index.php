<?php

declare(strict_types=1);

/**
 * Урок 20 — Включение файлов: include, require, _once.
 *
 * Практика: include/require, return, буферизация вывода,
 * пути через __DIR__, области видимости.
 *
 * Открой в браузере:
 * http://localhost/php-the-right-way/20-include-require/
 */

// ---------------------------------------------------------------------
// 1. Подготовка файлов для демонстрации.
// ---------------------------------------------------------------------

$baseDir = __DIR__;

// config.php — возвращает массив.
file_put_contents(
    $baseDir . '/config.php',
    <<<'PHP'
<?php
return [
    'db_host' => 'localhost',
    'db_name' => 'app',
    'debug' => true,
];
PHP
);

// partial.php — HTML-шаблон.
file_put_contents(
    $baseDir . '/partial.php',
    <<<'PHP'
<div class="card">
    <h3><?= htmlspecialchars($title) ?></h3>
    <p><?= htmlspecialchars($text) ?></p>
</div>
PHP
);

// functions.php — библиотека функций.
file_put_contents(
    $baseDir . '/functions.php',
    <<<'PHP'
<?php

if (!function_exists('formatPrice')) {
    function formatPrice(float $price): string
    {
        return number_format($price, 2, '.', ' ') . ' руб.';
    }
}
PHP
);

echo '<h3>1. Подготовка файлов</h3>';
echo 'Временные файлы созданы.<br>';

// ---------------------------------------------------------------------
// 2. include vs require.
// ---------------------------------------------------------------------

echo '<h3>2. include vs require</h3>';

// include — Warning, продолжение.
$result = @include $baseDir . '/nonexistent.php';
var_dump($result);   // bool(false)
echo '<br>После include скрипт продолжается.<br>';

// require — Fatal error (раскомментируй):
// require $baseDir . '/nonexistent.php';

// ---------------------------------------------------------------------
// 3. require_once для библиотек.
// ---------------------------------------------------------------------

echo '<h3>3. require_once</h3>';

require_once $baseDir . '/functions.php';
require_once $baseDir . '/functions.php';   // Не включится повторно

echo formatPrice(1234.5) . '<br>';

// ---------------------------------------------------------------------
// 4. return из конфига.
// ---------------------------------------------------------------------

echo '<h3>4. return из конфига</h3>';

$config = include $baseDir . '/config.php';

echo 'DB Host: ' . $config['db_host'] . '<br>';
echo 'DB Name: ' . $config['db_name'] . '<br>';
echo 'Debug: ' . var_export($config['debug'], true) . '<br>';

// ---------------------------------------------------------------------
// 5. Буферизация вывода.
// ---------------------------------------------------------------------

echo '<h3>5. Буферизация вывода</h3>';

$title = 'Заголовок карточки';
$text = 'Текст карточки';

ob_start();
include $baseDir . '/partial.php';
$html = ob_get_clean();

// Модификация.
$html = str_replace('class="card"', 'class="card highlighted"', $html);

echo $html;

// ---------------------------------------------------------------------
// 6. Буферизация с callback.
// ---------------------------------------------------------------------

echo '<h3>6. Callback в ob_start</h3>';

ob_start(function (string $buffer): string {
    return preg_replace('/\s+/', ' ', $buffer);
});

$title = 'Сжатая карточка';
$text = 'Текст';
include $baseDir . '/partial.php';
$minified = ob_get_clean();

echo 'Минифицировано: ' . htmlspecialchars($minified) . '<br>';

// ---------------------------------------------------------------------
// 7. Надёжные пути через __DIR__.
// ---------------------------------------------------------------------

echo '<h3>7. Пути через __DIR__</h3>';

// include 'config.php';             // Ненадёжно
include __DIR__ . '/config.php';    // Надёжно

echo 'Конфиг загружен через __DIR__.<br>';

// ---------------------------------------------------------------------
// 8. Область видимости.
// ---------------------------------------------------------------------

echo '<h3>8. Область видимости</h3>';

$message = 'Значение из index.php';

// Создаём файл, который использует $message.
file_put_contents(
    $baseDir . '/scope.php',
    <<<'PHP'
<?php
echo 'Сообщение: ' . $message;
PHP
);

include $baseDir . '/scope.php';
echo '<br>';

// ---------------------------------------------------------------------
// 9. Практический пример: шаблон с header и footer.
// ---------------------------------------------------------------------

echo '<h3>9. Шаблон с header/footer</h3>';

file_put_contents(
    $baseDir . '/header.php',
    <<<'PHP'
<header>
    <nav>Навигация</nav>
</header>
PHP
);

file_put_contents(
    $baseDir . '/footer.php',
    <<<'PHP'
<footer>
    <p>&copy; 2026</p>
</footer>
PHP
);

ob_start();
include $baseDir . '/header.php';
echo '<main>Контент страницы</main>';
include $baseDir . '/footer.php';
$page = ob_get_clean();

echo '<pre>' . htmlspecialchars($page) . '</pre>';

// ---------------------------------------------------------------------
// 10. Очистка временных файлов.
// ---------------------------------------------------------------------

echo '<h3>10. Очистка</h3>';

$tempFiles = ['config.php', 'partial.php', 'functions.php', 'scope.php', 'header.php', 'footer.php'];

foreach ($tempFiles as $file) {
    $path = $baseDir . '/' . $file;
    if (file_exists($path)) {
        unlink($path);
    }
}

echo 'Временные файлы удалены.<br>';

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;