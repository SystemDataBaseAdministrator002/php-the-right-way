# Работа с файловой системой в PHP 8

> Учебное пособие по PHP 8 · [Видеоурок](https://www.youtube.com/watch?v=p7F2GgVxHc0&list=PLr3d3QYzkw2xabQRUpcZ_IBk9W50M9pe-&index=31&pp=iAQB)

Этот урок — туториал по работе с файловой системой в PHP 8.

---

## Работа с каталогами

### `scandir()`

Возвращает массив файлов и каталогов:

```php
$files = scandir(__DIR__);
// ['.', '..', 'index.php', 'notes.md']

$files = scandir(__DIR__, SCANDIR_SORT_DESCENDING);
```

### `is_file()` и `is_dir()`

```php
var_dump(is_file('index.php'));   // true
var_dump(is_dir('partials'));     // true
```

### `mkdir()` и `rmdir()`

```php
mkdir('uploads');                             // Создать каталог
mkdir('project/assets/images', 0755, true);   // Рекурсивно
rmdir('empty_dir');                           // Удалить пустой каталог
```

Важно: `rmdir()` удаляет только пустой каталог. Для непустого — рекурсивная функция (см. ниже).

### `glob()` — альтернатива `scandir()`

```php
$phpFiles = glob(__DIR__ . '/*.php');
```

---

## Проверка и информация о файлах

```php
file_exists('file.txt');     // Существует ли
filesize('file.txt');        // Размер в байтах
is_file('file.txt');         // Это файл?
is_dir('uploads');           // Это каталог?
is_readable('file.txt');     // Доступен для чтения?
is_writable('file.txt');     // Доступен для записи?
```

Важно: PHP кэширует результаты этих функций. После изменения файла используй `clearstatcache()`:

```php
clearstatcache();
```

---

## Работа с содержимым файлов

### `file_put_contents()` и `file_get_contents()`

```php
// Запись (перезапись)
file_put_contents('file.txt', 'Hello');

// Добавление
file_put_contents('file.txt', "\nWorld", FILE_APPEND | LOCK_EX);

// Чтение
$content = file_get_contents('file.txt');

// Чтение с offset и length
$part = file_get_contents('file.txt', false, null, 5, 10);
```

Флаги `file_put_contents()`:

| Флаг | Описание |
| --- | --- |
| `FILE_APPEND` | Добавить, не перезаписывать |
| `LOCK_EX` | Блокировка на время записи |

### `fopen()` — режимы

| Режим | Чтение | Запись | Создание | Усечение | Указатель |
| --- | --- | --- | --- | --- | --- |
| `r` | Да | Нет | Нет | Нет | Начало |
| `r+` | Да | Да | Нет | Нет | Начало |
| `w` | Нет | Да | Да | Да | Начало |
| `w+` | Да | Да | Да | Да | Начало |
| `a` | Нет | Да | Да | Нет | Конец |
| `a+` | Да | Да | Да | Нет | Конец |
| `x` | Нет | Да | Да | — | Начало |
| `x+` | Да | Да | Да | — | Начало |
| `c` | Нет | Да | Да | Нет | Начало |
| `c+` | Да | Да | Да | Нет | Начало |

### Построчное чтение

```php
$fp = fopen('file.txt', 'r');

while (($line = fgets($fp)) !== false) {
    echo $line . '<br>';
}

fclose($fp);
```

### Запись через дескриптор

```php
$fp = fopen('file.txt', 'w');
fwrite($fp, "Hello\n");
fclose($fp);
```

### Чтение CSV

```php
if (($handle = fopen('data.csv', 'r')) !== false) {
    while (($row = fgetcsv($handle, 1000, ',')) !== false) {
        echo implode(' | ', $row) . '<br>';
    }
    fclose($handle);
}
```

---

## Работа с путями

```php
pathinfo('/var/www/index.php');
// ['dirname' => '/var/www', 'basename' => 'index.php', 'extension' => 'php', 'filename' => 'index']

basename('/var/www/index.php');   // 'index.php'
dirname('/var/www/index.php');    // '/var/www'
realpath('relative/path');        // Абсолютный путь
__DIR__;                          // Директория текущего файла
```

---

## Дополнительные операции

```php
unlink('file.txt');                  // Удалить файл
copy('source.txt', 'dest.txt');      // Копировать
rename('old.txt', 'new.txt');        // Переименовать / переместить
```

Чтение удалённых файлов (HTTP/FTP):

```php
// Требует allow_url_fopen = On
$content = file_get_contents('https://example.com');
```

---

## Рекурсивное удаление каталога

```php
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
```

---

## Краткие итоги

- `scandir`, `glob` — перечисление файлов.
- `is_file`, `is_dir`, `file_exists` — проверка.
- `file_get_contents`, `file_put_contents` — простое чтение/запись.
- `fopen`, `fgets`, `fwrite`, `fclose` — работа через дескриптор.
- `unlink`, `copy`, `rename`, `rmdir` — операции с файлами.
- `clearstatcache()` — сброс кэша.
- `__DIR__`, `realpath` — надёжные пути.

---

## Практика

Создай файл `index.php` и выполни следующие задачи:

1. Выведи список всех `.php`-файлов в текущей директории через `glob()`.
2. Создай каталог `uploads/thumbnails` рекурсивно через `mkdir()`.
3. Запиши строку в файл `log.txt` с добавлением (`FILE_APPEND`).
4. Прочитай файл `log.txt` построчно через `fgets()`.
5. Получи информацию о файле через `pathinfo()` и выведи `basename` и `extension`.
6. Прочитай CSV-файл через `fgetcsv()` и выведи данные в виде таблицы.
7. Реализуй функцию `removeDir()` для рекурсивного удаления каталога.
8. Скопируй файл `source.txt` в `backup/source.txt` через `copy()`.