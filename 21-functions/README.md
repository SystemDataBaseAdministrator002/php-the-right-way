# Создание функций в PHP 8

> Учебное пособие по PHP 8 · [Видеоурок](https://www.youtube.com/watch?v=ba1rulfNhLk&list=PLr3d3QYzkw2xabQRUpcZ_IBk9W50M9pe-&index=22&pp=iAQB)

Этот урок — туториал по созданию функций в PHP 8.

## Создание функции

Функция создаётся ключевым словом `function`:

```php
function functionName($param1, $param2)
{
    // тело функции
    return $result;
}
```

Правила именования:

- Имя начинается с буквы или подчёркивания.
- Далее — буквы, цифры, подчёркивания.
- Регистр не важен (`myFunc` и `MYFUNC` — одна функция).
- Параметры необязательны. Функция без параметров тоже допустима.

### Вызов функции

```php
function greet(): void
{
    echo 'Hello';
}

greet();   // Hello
```

Где можно определять:

- В любой части скрипта. Функции глобальны — их видно везде после объявления.
- Исключения: условное объявление и функции внутри функций (см. ниже).

---

## Типы возвращаемых значений

После списка параметров через двоеточие указывается тип возвращаемого значения:

```php
function add(int $a, int $b): int
{
    return $a + $b;
}
```

Виды типов:

| Тип | Описание |
| --- | --- |
| `int`, `float`, `string`, `bool` | Скалярные |
| `array`, `object`, `callable`, `iterable` | Составные |
| `void` | Ничего не возвращает |
| `never` (PHP 8.1) | Никогда не завершается нормально |
| `mixed` | Любой тип |
| `?type` | Nullable: `type` или `null` |
| `type1\|type2` (PHP 8.0) | Union-тип |

Примеры:

```php
function noReturn(): void
{
    echo 'Hello';
}

function nullable(): ?string
{
    return null;
}

function union(): int|float
{
    return 1.5;
}

function mixedType(): mixed
{
    return [1, 2, 3];
}
```

Важно: `?mixed` вызывает ошибку — `mixed` уже включает `null`.

### Без `strict_types`

Без `declare(strict_types=1)` PHP приводит типы автоматически:

```php
function add(int $a, int $b): int
{
    return $a + $b;
}

echo add('1', 2);   // 3 (строка '1' приводится к int)
```

Со `strict_types=1` такая передача вызовет `TypeError`.

---

## Особые случаи определения

### Условное определение

Функцию можно объявить внутри условия:

```php
if (!function_exists('helper')) {
    function helper(): string
    {
        return 'ok';
    }
}

helper();   // ok
```

Особенности:

- Функцию нельзя вызвать до того, как условие выполнится.
- Имя функции глобальное. Повторное объявление вызовет `Fatal error`.
- `function_exists()` предотвращает ошибку при повторном `include`.

### Функция внутри функции

```php
function outer(): void
{
    function inner(): string
    {
        return 'inner';
    }
}

// inner() ещё не существует:
// inner();   // Fatal error

outer();       // Теперь inner() определена
echo inner();  // inner
```

Особенности:

- `inner()` становится глобальной после первого вызова `outer()`.
- Вызов `inner()` до `outer()` — фатальная ошибка.
- Повторный вызов `outer()` вызовет `Cannot redeclare inner()`.

Рекомендация: избегай этого паттерна — он усложняет чтение и отладку.

### Перекрытие встроенных функций в namespace

В своём namespace можно объявить функцию с именем встроенной:

```php
namespace App;

function strlen(string $s): int
{
    return 0;
}

strlen('abc');    // App\strlen → 0
\strlen('abc');   // Глобальный → 3
```

Легальный способ «подменить» поведение только в своей области.

---

## Анонимные и стрелочные функции

Анонимные функции можно присваивать переменным и передавать как значения:

```php
$fn = function ($x) {
    return $x * 2;
};

$arrow = fn($x) => $x * 2;

echo $fn(5);      // 10
echo $arrow(5);   // 10
```

### First-class callable syntax (PHP 8.1+)

Начиная с PHP 8.1, можно создавать callable из функции через `(...)`:

```php
$strlen = strlen(...);
echo $strlen('Hello');   // 5

$fn = strtoupper(...);
echo $fn('hello');       // HELLO
```

---

## Параметры по ссылке

По умолчанию параметры передаются по значению. Чтобы передать по ссылке — используй `&`:

```php
function increment(int &$value): void
{
    $value++;
}

$count = 5;
increment($count);
echo $count;   // 6
```

---

## Параметры по умолчанию

```php
function greet(string $name = 'Guest'): string
{
    return "Hello, $name";
}

echo greet();         // Hello, Guest
echo greet('Gio');    // Hello, Gio
```

---

## Рекурсия

Функция может вызывать саму себя:

```php
function factorial(int $n): int
{
    if ($n <= 1) {
        return 1;
    }
    return $n * factorial($n - 1);
}

echo factorial(5);   // 120
```

---

## Ограничения

- Нельзя создать две функции с одинаковым именем — `Fatal error`.
- Нельзя переопределить встроенную функцию в глобальном namespace — но можно в своём.

### Практика: `function_exists()`

Стандартный приём для библиотек и хелперов:

```php
if (!function_exists('helper')) {
    function helper(): void
    {
        // ...
    }
}
```

Это предотвращает ошибку при повторном `include` файла.