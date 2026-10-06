# Конфигурация PHP: php.ini

> Учебное пособие по PHP 8 · [Видеоурок](https://www.youtube.com/watch?v=LVEhccXXnOo&list=PLr3d3QYzkw2xabQRUpcZ_IBk9W50M9pe-&index=28&pp=iAQB)

Этот урок — туториал по работе с файлом конфигурации `php.ini` в PHP 8.

## Что такое `php.ini`

`php.ini` — главный файл конфигурации PHP. В нём задаются директивы, определяющие поведение интерпретатора: уровень ошибок, лимиты памяти, часовой пояс, загрузка расширений и т.д.

### Синтаксис

```ini
; Это комментарий

[PHP]                          ; Секция
memory_limit = 256M            ; Директива
display_errors = Off
```

- Квадратные скобки — секции (группы директив).
- Точка с запятой — комментарий.
- `=` — разделитель между именем директивы и значением.
- Пробелы вокруг `=` допустимы.
- Значения могут быть в кавычках.

---

## Как найти `php.ini`

**Способ 1: командная строка**

```bash
php --ini
```

**Способ 2: через PHP**

```php
echo php_ini_loaded_file();      // Загруженный файл
echo php_ini_scanned_files();    // Дополнительные .ini
```

**Способ 3: через `phpinfo()`**

```php
phpinfo();
// Ищи "Loaded Configuration File"
```

**Способ 4: XAMPP**

Кнопка Config рядом с Apache в панели управления.

---

## Режимы директив

Каждая директива имеет режим, определяющий, где её можно менять:

| Режим | Где можно изменить |
| --- | --- |
| `PHP_INI_USER` | `ini_set()`, `.user.ini` |
| `PHP_INI_PERDIR` | `.htaccess`, `.user.ini`, `php.ini` |
| `PHP_INI_SYSTEM` | Только `php.ini`, `httpd.conf` |
| `PHP_INI_ALL` | Везде |

Важно: если директива помечена `PHP_INI_SYSTEM`, `ini_set()` не сработает.

---

## Способы изменения

### 1. Через `php.ini` (глобально)

Меняет поведение для всех скриптов. Требует перезапуска Apache (или PHP-FPM).

### 2. Через `ini_set()` (в рантайме)

Меняет поведение только в текущем скрипте. Не работает для `PHP_INI_SYSTEM`-директив.

```php
$old = ini_set('memory_limit', '256M');
if ($old === false) {
    echo 'Директива не изменяема в рантайме';
}

echo ini_get('memory_limit');   // Текущее значение
```

### 3. Через `.user.ini` (для shared-хостинга)

Файл `.user.ini` в директории проекта. Работает для `PHP_INI_PERDIR`-директив.

```ini
upload_max_filesize = 20M
post_max_size = 25M
```

---

## Ключевые директивы

### Ошибки

```ini
error_reporting = E_ALL
display_errors = Off           ; Продакшен
display_startup_errors = Off
log_errors = On
error_log = /var/log/php/error.log
log_errors_max_len = 1024
html_errors = Off
```

Уровни `error_reporting`:

| Значение | Что включает |
| --- | --- |
| `E_ALL` | Все ошибки (кроме `E_STRICT`, удалён в PHP 8.0) |
| `E_ALL & ~E_NOTICE` | Все, кроме notice |
| `E_ALL & ~E_DEPRECATED` | Все, кроме deprecated |
| `0` | Ничего |

Важно: начиная с PHP 8.0 константа `E_STRICT` больше не используется — ошибки этого типа не генерируются.

### Лимиты

```ini
memory_limit = 128M            ; По умолчанию 128M
max_execution_time = 30        ; Для веба; для CLI — 0
max_input_time = 60            ; Время парсинга входных данных
```

### Загрузка файлов

```ini
file_uploads = On
upload_max_filesize = 20M
post_max_size = 25M            ; Должно быть >= upload_max_filesize
max_file_uploads = 20
upload_tmp_dir = /tmp
max_input_vars = 3000
```

### Часовой пояс

```ini
date.timezone = UTC
```

### Пути

```ini
include_path = ".:/usr/share/php"
```

### Безопасность

```ini
expose_php = Off               ; Скрыть версию PHP в заголовках
disable_functions = exec,passthru,shell_exec,system
allow_url_fopen = Off
allow_url_include = Off
open_basedir = /var/www/html
session.cookie_httponly = 1
session.cookie_secure = 1
```

### OPcache

```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=10000
opcache.validate_timestamps=1
opcache.revalidate_freq=2
```

### Отладка

```ini
zend.assertions = 1            ; Разработка
zend.assertions = -1           ; Продакшен
```

---

## Пример: настройка ошибок

### Для разработки

```ini
error_reporting = E_ALL
display_errors = On
display_startup_errors = On
log_errors = On
html_errors = On
```

### Для продакшена

```ini
error_reporting = E_ALL & ~E_DEPRECATED
display_errors = Off
display_startup_errors = Off
log_errors = On
error_log = /var/log/php/error.log
html_errors = Off
```

### В рантайме (в скрипте)

```php
error_reporting(E_ALL);
ini_set('display_errors', '1');
```

Важно: `error_reporting()` и `ini_set('error_reporting', ...)` эквивалентны.

---

## Краткие итоги

- `php.ini` — главный конфиг PHP.
- Способы найти — `php --ini`, `phpinfo()`, `php_ini_loaded_file()`.
- Режимы — `PHP_INI_USER`, `PHP_INI_PERDIR`, `PHP_INI_SYSTEM`, `PHP_INI_ALL`.
- `ini_set()` — только для рантайма и не для `PHP_INI_SYSTEM`.
- Для продакшена: `display_errors = Off`, `log_errors = On`.
- OPcache — обязателен для производительности.
- Безопасность: `disable_functions`, `open_basedir`, `allow_url_include = Off`.

---

## Практика

Создай файл `index.php` и выполни следующие задачи:

1. Выведи путь к загруженному `php.ini` с помощью `php_ini_loaded_file()`.
2. Получи текущее значение `memory_limit` через `ini_get()` и выведи его.
3. Установи `memory_limit` в `512M` через `ini_set()` и проверь, что изменилось.
4. Выведи все настройки PHP через `phpinfo()` и найди `Loaded Configuration File`.
5. Проверь, можно ли изменить `disable_functions` через `ini_set()` — если нет, объясни почему.
6. Создай файл `.user.ini` с настройками `upload_max_filesize = 50M` и `post_max_size = 60M`.
7. Напиши скрипт, который устанавливает `error_reporting(E_ALL)` и `ini_set('display_errors', '1')` в начале, а затем вызывает функцию с предупреждением.
8. Выведи текущий часовой пояс через `ini_get('date.timezone')` и установи новый через `ini_set('date.timezone', 'Europe/Moscow')`.