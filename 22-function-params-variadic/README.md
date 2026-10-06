# Параметры функций: именованные аргументы, variadic, splat

> Учебное пособие по PHP 8 · [Видеоурок](https://www.youtube.com/watch?v=I9XkWyets9w&list=PLr3d3QYzkw2xabQRUpcZ_IBk9W50M9pe-&index=23&pp=iAQB)

Этот урок — туториал по работе с параметрами функций в PHP 8.

## Параметры и аргументы

- **Параметры** задаются при **определении** функции.
- **Аргументы** передаются при **вызове**.

```php
function foo(int $x, int $y): int
{
    return $x + $y;
}

foo(5, 10);   // 5 и 10 — аргументы
```

## Значения по умолчанию

```php
function greet(string $name, string $greeting = 'Hello'): string
{
    return "$greeting, $name";
}

echo greet('Gio');            // Hello, Gio
echo greet('Gio', 'Hi');      // Hi, Gio
```

Правила:

- Значения по умолчанию должны быть постоянными выражениями (нельзя вызывать функции).
- Необязательные параметры идут после обязательных.

Передача по ссылке:

```php
function increment(int &$value): void
{
    $value++;
}
```

---

## Вариативные функции (variadic)

Функция принимает переменное число аргументов:

```php
function sum(int ...$numbers): int
{
    return array_sum($numbers);
}

echo sum(1, 2, 3);         // 6
echo sum(10, 20, 30, 40);  // 100
```

`$numbers` — обычный массив, с ним работают `foreach`, `array_map` и т.д.

Комбинирование с фиксированными параметрами:

```php
function logMessage(string $level, ...$messages): void
{
    echo "[$level] " . implode(' ', $messages) . "\n";
}

logMessage('INFO', 'User', 'logged', 'in');
// [INFO] User logged in
```

Ограничения:

- Только один вариативный параметр.
- Он должен быть последним.
- Не может иметь значение по умолчанию.

```php
// Ошибки:
// function foo(...$args, $x) {}
// function foo(...$a, ...$b) {}
// function foo(...$args = []) {}
```

Union-типы для вариативных параметров (PHP 8.0+):

```php
function process(int|string ...$items): void {}
```

Устаревший подход — `func_get_args()`:

```php
function sum(): int
{
    return array_sum(func_get_args());
}
```

---

## Оператор splat `...`

Оператор `...` (spread) выполняет две противоположные задачи в зависимости от места:

### 1. Сбор аргументов (в определении функции)

```php
function sum(...$numbers): int
{
    return array_sum($numbers);
}
```

### 2. Распаковка массива при вызове

```php
function multiply($a, $b, $c)
{
    return $a * $b * $c;
}

$values = [2, 3, 4];
echo multiply(...$values);   // 24
```

При распаковке числовые ключи игнорируются:

```php
$args = [1 => 'a', 5 => 'b'];
foo(...$args);   // То же, что foo('a', 'b')
```

Распаковка Traversable:

```php
function gen(): Generator
{
    yield 1;
    yield 2;
    yield 3;
}

$list = [...gen()];   // [1, 2, 3]
```

Важно: при вызове функции можно распаковать `array` и `Traversable`. В литерале массива — только `array` (PHP 7.4+).

### Сравнение с `array_merge()`

```php
$a = [1, 2];
$b = [3, 4];
$merged = [...$a, ...$b];   // [1, 2, 3, 4]

$stringKeys1 = ['color' => 'red'];
$stringKeys2 = ['color' => 'blue', 'size' => 'M'];
$config = [...$stringKeys1, ...$stringKeys2];
// ['color' => 'blue', 'size' => 'M']
```

| Операция | Числовые ключи | Строковые ключи |
| --- | --- | --- |
| `+` | Оставляет первый | Оставляет первый |
| `array_merge()` | Переиндексирует | Перезаписывает |
| `[...$a, ...$b]` (PHP 8.1+) | Переиндексирует | Перезаписывает |

Важно: ассоциативная распаковка работает только со строковыми ключами и появилась в PHP 8.1.

---

## Именованные аргументы (PHP 8.0+)

```php
function greet(string $name, string $greeting = 'Hello'): string
{
    return "$greeting, $name";
}

echo greet(name: 'Alice', greeting: 'Hi');
echo greet(greeting: 'Hi', name: 'Alice');   // Порядок не важен
```

Удобство с параметрами по умолчанию:

```php
function buildCookieString(
    string $name,
    string $value = '',
    int $expires = 0,
    string $path = '/',
    bool $secure = false,
    bool $httpOnly = false
): void {}

// Передаём только нужные:
buildCookieString(
    name: 'session',
    value: 'abc123',
    httpOnly: true
);
```

Правила:

- Нельзя передавать один параметр дважды.
- Позиционные аргументы — до именованных.
- После именованного нельзя передать позиционный — Fatal error.

```php
foo(1, b: 2, c: 3);   // OK
foo(1, b: 2, 3);      // Fatal error: Cannot use positional argument after named argument
```

Распаковка ассоциативного массива:

```php
function greet(string $name, string $greeting = 'Hello') {}

$args = ['name' => 'Alice', 'greeting' => 'Hi'];
greet(...$args);   // Hi, Alice!
```

Ключи массива трактуются как имена параметров. Это тоже PHP 8.0+.

---

## Краткие итоги

- **Параметры** задаются при определении, **аргументы** — при вызове.
- **Значения по умолчанию** — только константные выражения, после обязательных.
- **Variadic** (`...$args`) — переменное число аргументов, только один, последним.
- **Splat** при вызове — распаковка массива в аргументы.
- **Именованные аргументы** (PHP 8.0+) — передача по имени, порядок не важен.
- **`array_merge()` vs spread** — spread быстрее, но строковые ключи только с PHP 8.1.

---

## Практика

1. Напиши функцию `formatPrice(float $price, string $currency = '₽', int $decimals = 2): string` и вызови её с именованными аргументами, передав только `price` и `decimals`.
2. Создай вариативную функцию `maxValue(int ...$numbers): int`, возвращающую максимальное значение.
3. Напиши функцию `logMessage(string $level, string ...$messages): void`, которая выводит `[LEVEL] message1 message2 ...`.
4. Распакуй массив `$args = [1, 2, 3]` в функцию `multiply($a, $b, $c)` через splat.
5. Создай функцию `createUser(string $name, int $age = 18, bool $active = true, string $role = 'user'): array` и вызови её, передав только `name` и `role` через именованные аргументы.
6. Напиши функцию `sum(...$numbers)`, которая использует `array_sum()`, и вызови её с распаковкой массива.
7. Объедини два ассоциативных массива через spread и через `array_merge()`, сравни результаты.
8. Напиши функцию с параметром по ссылке `addToTotal(int &$total, int $amount): void` и продемонстрируй изменение исходной переменной.