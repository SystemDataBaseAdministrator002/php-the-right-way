<?php

declare(strict_types=1);

/**
 * Урок 30 — Работа с файловой системой.
 *
 * Практика: scandir, mkdir, rmdir, file_get_contents,
 * file_put_contents, fopen, fgets, fgetcsv, unlink, copy, rename.
 *
 * Открой в браузере:
 * http://localhost/php-the-right-way/30-filesystem/
 */

$baseDir = __DIR__ . '/sandbox';
$logFile = $baseDir . '/log.txt';
$csvFile = $baseDir . '/data.csv';

// ---------------------------------------------------------------------
// 1. Создание и удаление каталога.
// ---------------------------------------------------------------------

echo '<h3>1. Каталоги</h3>';

if (!is_dir($baseDir)) {
    mkdir($baseDir, 0755, true);
    echo 'Каталог создан: ' . $baseDir . '<br>';
} else {
    echo 'Каталог уже существует.<br>';
}

// Рекурсивное создание.
$nested = $baseDir . '/a/b/c';
mkdir($nested, 0755, true);
echo 'Вложенные каталоги созданы.<br>';

// ---------------------------------------------------------------------
// 2. scandir и glob.
// ---------------------------------------------------------------------

echo '<h3>2. scandir / glob</h3>';

$items = scandir($baseDir);
echo '<pre>';
print_r(array_diff($items, ['.', '..']));
echo '</pre>';

// glob для PHP-файлов.
$phpFiles = glob(__DIR__ . '/*.php');
echo 'PHP-файлов: ' . count($phpFiles) . '<br>';

// ---------------------------------------------------------------------
// 3. file_put_contents / file_get_contents.
// ---------------------------------------------------------------------

echo '<h3>3. file_put_contents / file_get_contents</h3>';

file_put_contents($logFile, "Строка 1\n");
file_put_contents($logFile, "Строка 2\n", FILE_APPEND | LOCK_EX);

$content = file_get_contents($logFile);
echo '<pre>' . htmlspecialchars($content) . '</pre>';

// Чтение с offset.
$part = file_get_contents($logFile, false, null, 9, 7);
echo 'Часть: ' . htmlspecialchars($part) . '<br>';

// ---------------------------------------------------------------------
// 4. fopen / fgets / fclose.
// ---------------------------------------------------------------------

echo '<h3>4. fopen / fgets / fclose</h3>';

$fp = fopen($logFile, 'r');

while (($line = fgets($fp)) !== false) {
    echo htmlspecialchars($line) . '<br>';
}

fclose($fp);

// ---------------------------------------------------------------------
// 5. fwrite.
// ---------------------------------------------------------------------

echo '<h3>5. fwrite</h3>';

$fp = fopen($baseDir . '/write.txt', 'w');
fwrite($fp, "Написано через fwrite\n");
fclose($fp);

echo 'Файл write.txt создан.<br>';

// ---------------------------------------------------------------------
// 6. CSV: fgetcsv.
// ---------------------------------------------------------------------

echo '<h3>6. fgetcsv</h3>';

file_put_contents($csvFile, "name,age\nAlice,25\nBob,30\n");

if (($handle = fopen($csvFile, 'r')) !== false) {
    echo '<table border="1">';
    while (($row = fgetcsv($handle, 1000, ',')) !== false) {
        echo '<tr>';
        foreach ($row as $cell) {
            echo '<td>' . htmlspecialchars($cell) . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
    fclose($handle);
}

// ---------------------------------------------------------------------
// 7. Копирование, переименование, удаление.
// ---------------------------------------------------------------------

echo '<h3>7. copy / rename / unlink</h3>';

$copyFile = $baseDir . '/copy.txt';
copy($logFile, $copyFile);
echo 'Файл скопирован.<br>';

$renamedFile = $baseDir . '/renamed.txt';
rename($copyFile, $renamedFile);
echo 'Файл переименован.<br>';

unlink($renamedFile);
echo 'Файл удалён.<br>';

// ---------------------------------------------------------------------
// 8. pathinfo / basename / dirname.
// ---------------------------------------------------------------------

echo '<h3>8. Работа с путями</h3>';

$path = __FILE__;
echo '<pre>';
print_r(pathinfo($path));
echo '</pre>';

echo 'basename: ' . basename($path) . '<br>';
echo 'dirname: ' . dirname($path) . '<br>';
echo '__DIR__: ' . __DIR__ . '<br>';
echo 'realpath: ' . realpath($logFile) . '<br>';

// ---------------------------------------------------------------------
// 9. clearstatcache.
// ---------------------------------------------------------------------

echo '<h3>9. clearstatcache</h3>';

echo 'Размер до: ' . filesize($logFile) . '<br>';
file_put_contents($logFile, 'Ещё строка', FILE_APPEND);
clearstatcache();
echo 'Размер после: ' . filesize($logFile) . '<br>';

// ---------------------------------------------------------------------
// 10. Рекурсивное удаление каталога.
// ---------------------------------------------------------------------

echo '<h3>10. Рекурсивное удаление</h3>';

function removeDir(string $dir): void
{
    if (!is_dir($dir)) {
        return;
    }

    foreach (scandir($dir) as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }

        $path = $dir . DIRECTORY_SEPARATOR . $item;

        is_dir($path) ? removeDir($path) : unlink($path);
    }

    rmdir($dir);
}

removeDir($baseDir);
echo 'Sandbox удалён: ' . (is_dir($baseDir) ? 'нет' : 'да') . '<br>';

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;