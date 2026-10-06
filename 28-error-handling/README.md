# Обработка ошибок в PHP 8

> Учебное пособие по PHP 8 · [Видеоурок](https://www.youtube.com/watch?v=rQntgj7yink&list=PLr3d3QYzkw2xabQRUpcZ_IBk9W50M9pe-&index=29&pp=iAQB)

Этот урок — туториал по обработке ошибок в PHP 8: типы, настройка, `trigger_error`, `set_error_handler`, исключения.

## Типы ошибок в PHP

PHP различает несколько уровней ошибок. Основные:

| Константа | Описание | Останавливает скрипт |
| --- | --- | --- |
| `E_ERROR` | Фатальная ошибка | Да |
| `E_WARNING` | Предупреждение | Нет |
| `E_PARSE` | Ошибка синтаксиса | Да |
| `E_NOTICE` | Уведомление | Нет |
| `E_DEPRECATED` | Устаревший код | Нет |
| `E_USER_ERROR` | Пользовательская фатальная | Да |
| `E_USER_WARNING` | Пользовательское предупреждение | Нет |
| `E_USER_NOTICE` | Пользовательское уведомление | Нет |
| `E_USER_DEPRECATED` | Пользовательское устаревание | Нет |

**Важно:** `E_STRICT` не используется начиная с **PHP 8.0**.

---

## Настройка отчётности об ошибках

### В `php.ini`

```ini
; Разработка
error_reporting = E_ALL
display_errors = On
display_startup_errors = On
log_errors = On

; Продакшен
error_reporting = E_ALL & ~E_DEPRECATED
display_errors = Off
log_errors = On
error_log = /var/log/php/error.log
```

### В рантайме

```php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('log_errors', '1');
```

Рекомендация: используй `E_ALL` в разработке, чтобы отслеживать все проблемы.

---

## `trigger_error()` — ручной вызов ошибок

```php
bool trigger_error(string $error_msg, int $error_type = E_USER_NOTICE)
```

Доступные типы:

- `E_USER_ERROR`
- `E_USER_WARNING`
- `E_USER_NOTICE`
- `E_USER_DEPRECATED`

Важно: обычные константы (`E_ERROR`, `E_WARNING`) использовать нельзя — вызовет ошибку.

```php
if ($divisor === 0) {
    trigger_error('Деление на ноль', E_USER_WARNING);
}
```

### ⚠️ Изменение в PHP 8.4

Передача `E_USER_ERROR` в `trigger_error()` объявлена устаревшей. Вместо этого:

```php
// Устаревший способ (PHP 8.4: deprecated)
trigger_error('Fatal', E_USER_ERROR);

// Рекомендуемый способ:
throw new Error('Fatal error');
// или
exit('Fatal error');
```

---

## Пользовательский обработчик ошибок

```php
set_error_handler(callable $callback, int $error_levels = E_ALL): ?callable
```

Callback принимает:

```php
function handler(
    int $errno,          // Уровень ошибки
    string $errstr,      // Сообщение
    string $errfile,     // Файл
    int $errline         // Строка
): bool
```

Пример:

```php
function customErrorHandler(int $errno, string $errstr, string $errfile, int $errline): bool
{
    error_log("[$errno] $errstr in $errfile:$errline");

    if ($errno === E_USER_ERROR) {
        exit(1);
    }

    return true;   // Не передавать стандартному обработчику
}

set_error_handler('customErrorHandler', E_ALL);
```

Возврат:

- `false` — вернуться к стандартной обработке.
- `true` — подавить стандартную обработку.

### Ограничения `set_error_handler()`

Нельзя обработать:

- `E_ERROR`
- `E_PARSE`
- `E_CORE_ERROR`
- `E_CORE_WARNING`
- `E_COMPILE_ERROR`
- `E_COMPILE_WARNING`

Эти ошибки фатальны и происходят до или во время компиляции.

Также нельзя:

- Обработать ошибки, произошедшие до регистрации обработчика.
- Обработать ошибки загрузки файлов (происходят до выполнения скрипта).

### Восстановление обработчика

```php
$previous = set_error_handler('myHandler');
// ...
restore_error_handler();   // Вернуть предыдущий
```

---

## Исключения — современный подход

В современном PHP ошибки обрабатываются через исключения:

```php
try {
    $result = riskyOperation();
} catch (InvalidArgumentException $e) {
    echo 'Некорректный аргумент: ' . $e->getMessage();
} catch (Throwable $e) {
    echo 'Ошибка: ' . $e->getMessage();
} finally {
    echo 'Выполняется всегда';
}
```

### `ErrorException` — мост между ошибками и исключениями

```php
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        return false;
    }
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});
```

Это стандартный приём в Laravel и Symfony.

---

## Обработка фатальных ошибок

Фатальные ошибки нельзя перехватить через `set_error_handler`. Используй `register_shutdown_function`:

```php
register_shutdown_function(function () {
    $error = error_get_last();

    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        error_log("Fatal: {$error['message']} in {$error['file']}:{$error['line']}");
    }
});
```

---

## Ручное логирование

```php
error_log('Сообщение', 3, '/var/log/my.log');
```

---

## Рекомендации

- Разработка: `error_reporting = E_ALL`, `display_errors = On`.
- Продакшен: `error_reporting = E_ALL & ~E_DEPRECATED`, `display_errors = Off`, `log_errors = On`.
- Используй исключения вместо `trigger_error` в новом коде.
- `ErrorException` — для преобразования ошибок в исключения.
- `register_shutdown_function` — для обработки фатальных ошибок.

---

## Практика

Создай файл `index.php` и выполни следующие задачи:

1. Выведи все ошибки на экран с помощью `error_reporting()` и `ini_set()`.
2. Вызови `trigger_error()` с уровнем `E_USER_WARNING` и перехвати его через `set_error_handler()`.
3. Создай кастомный обработчик, который логирует все ошибки в файл `errors.log`.
4. Брось `InvalidArgumentException` в `try`/`catch` и выведи сообщение.
5. Зарегистрируй `register_shutdown_function`, который выводит «Скрипт завершён».
6. Преобразуй `E_WARNING` в `ErrorException` через `set_error_handler`.
7. В `try`/`catch`/`finally` продемонстрируй, что `finally` выполняется всегда.
8. Вызови `error_log()` для записи сообщения в файл `my.log`.