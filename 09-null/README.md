# Тип данных Null

> Учебное пособие по PHP 8 · [Видеоурок](https://www.youtube.com/watch?v=XspbsepnhQ4&list=PLr3d3QYzkw2xabQRUpcZ_IBk9W50M9pe-&index=10&pp=iAQB)

Этот урок — туториал по типу данных `null` в PHP 8.

## Что такое `null`

`null` — это **unit type** PHP: тип, который имеет **ровно одно возможное значение** — константу `null`. Это значение представляет переменную без значения.

Константа `null` **нечувствительна к регистру**: `null`, `NULL`, `Null` — всё допустимо.

## Когда переменная становится `null`

Переменная считается `null`, если:

1. Ей присвоена константа `null`.
2. Она ещё не определена.
3. Она удалена через `unset()`.

```php
$a = null;          // присвоено
$b;                 // неопределена (при обращении — Warning, значение null)
$c = 1;
unset($c);          // удалена
```

## Как проверить `null`

| Способ | Синтаксис | Особенности |
| --- | --- | --- |
| `is_null()` | `is_null($var)` | Функция, работает с неопределёнными переменными |
| `===` | `$var === null` | Строгое сравнение |
| `var_dump()` | `var_dump($var)` | Для отладки |

Таблица различий:

| Проверка | `null` | Не определена | `0` | `""` | `false` |
| --- | --- | --- | --- | --- | --- |
| `is_null($var)` | `true` | `true` | `false` | `false` | `false` |
| `$var === null` | `true` | `true` | `false` | `false` | `false` |
| `isset($var)` | `false` | `false` | `true` | `true` | `true` |
| `empty($var)` | `true` | `true` | `true` | `true` | `true` |

## Преобразование `null`

При приведении к другим типам `null` даёт:

| Целевой тип | Результат |
| --- | --- |
| `string` | `""` (пустая строка) |
| `int` | `0` |
| `float` | `0.0` |
| `bool` | `false` |
| `array` | `[]` (пустой массив) |

```php
var_dump((string) null);   // string(0) ""
var_dump((int) null);      // int(0)
var_dump((bool) null);     // bool(false)
var_dump((array) null);    // array(0) {}
```

Отличие от `false`: `(string) false` даёт `"0"`, а `(string) null` — `""`. Это частая ловушка при отладке.

## Операторы для работы с `null`

### `??` — null coalescing operator (PHP 7.0+)

Возвращает первый операнд, если он не `null`, иначе — второй:

```php
$username = $_GET['username'] ?? 'nobody';
// Эквивалент:
// $username = isset($_GET['username']) ? $_GET['username'] : 'nobody';
```

Ключевое отличие от `?:` — `??` проверяет не только `null`, но и неопределённые переменные.

Можно объединять в цепочки:

```php
$value = $a ?? $b ?? $c ?? 'default';
```

### `?->` — nullsafe operator (PHP 8.0+)

Позволяет безопасно обращаться к свойствам и методам объекта, возвращая `null`, если объект равен `null`:

```php
$location = $user->profile?->location;
// Эквивалент:
// if (is_null($user->profile)) {
//     $location = null;
// } else {
//     $location = $user->profile->location;
// }
```

Объединяется с `??`:

```php
$country = $user->profile?->address?->country ?? 'Unknown';
```

## Nullable types (PHP 7.1+)

Синтаксис `?type` — это сахар для `type|null`:

```php
function greet(?string $name): ?string
{
    return $name ? "Hello, $name" : null;
}
```

В PHP 8.0 можно использовать union-типы:

```php
function find(int $id): User|null
{
    // ...
}
```

## Важные нюансы

### `isset()` vs `array_key_exists()`

`isset()` возвращает `false` для ключа со значением `null`, а `array_key_exists()` — `true`:

```php
$array = ['key' => null];
var_dump(isset($array['key']));           // bool(false)
var_dump(array_key_exists('key', $array)); // bool(true)
```

### Deprecation в PHP 8.1

Передача `null` в параметр встроенной функции, который не помечен как nullable, вызывает deprecation notice:

```php
// PHP 8.1+: Deprecated
strlen(null);
```

### `(unset)` cast — удалён

Раньше существовал `(unset) $var`, который возвращал `null`, не удаляя переменную. В PHP 7.2 — deprecated, в PHP 8.0 — удалён.

## Где используется `null`

- Значения по умолчанию для параметров функций.
- Возвращаемое значение функций, которые могут ничего не найти.
- Свойства объектов, значение которых неизвестно.
- Результаты запросов к БД, где поле может быть `NULL`.
- Обработка форм — отсутствующие поля.

## Дополнительно: `match` с `null` (PHP 8.0+)

```php
$result = match ($value) {
    null => 'Значение отсутствует',
    default => 'Значение есть',
};
```

---

### Практика для урока: `index.php`

Идея: **чистая практика по `null`** — проверка, преобразование, операторы.

Файл должен демонстрировать:

1. Присвоение `null` и проверку через `is_null()`, `===`, `var_dump()`.
2. Поведение неопределённой переменной и `unset()`.
3. Преобразование `null` к другим типам (`(int)`, `(string)`, `(bool)`, `(array)`).
4. Отличие `(string) null` от `(string) false`.
5. Оператор `??` — базовый и цепочкой.
6. Оператор `?->` — безопасный доступ к свойствам.
7. `isset()` vs `array_key_exists()` для ключа со значением `null`.