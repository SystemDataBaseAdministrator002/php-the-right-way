# Анонимные функции, замыкания и стрелочные функции

> Учебное пособие по PHP 8 · [Видеоурок](https://www.youtube.com/watch?v=7_FOIxYLF-s&list=PLr3d3QYzkw2xabQRUpcZ_IBk9W50M9pe-&index=25&pp=iAQB)

Этот урок — туториал по переменным функциям, анонимным функциям,
замыканиям, callable, callback и стрелочным функциям.

## Переменные функции

Функцию можно вызвать через переменную, добавив круглые скобки:

```php
function greet(string $name): string
{
    return "Hello, $name";
}

$fn = 'greet';
echo $fn('Gio');   // Hello, Gio
```

Проверка существования:

```php
if (is_callable($fn)) {
    $fn('Gio');
}
```

Ограничение: переменные функции не работают с языковыми конструкциями
(`echo`, `print`, `isset`, `empty`, `unset`, `include`, `require` и т.п.).
Для них нужны функции-обёртки:

```php
function my_echo(string $s): void { echo $s; }

$fn = 'my_echo';
$fn('Hello');   // Hello
```

---

## Анонимные функции

Анонимная функция — функция без имени. Заканчивается `;`:

```php
$greet = function (string $name): string {
    return "Hello, $name";
};

echo $greet('Gio');   // Hello, Gio
```

Можно:

- присваивать переменным;
- передавать как аргумент;
- возвращать из функции.

---

## Замыкания (use)

Замыкание — анонимная функция, которая захватывает переменные
из родительской области через `use`:

```php
$name = 'Gio';

$greet = function () use ($name) {
    echo "Hello, $name";
};

$greet();   // Hello, Gio
```

### Захват по значению (по умолчанию)

```php
$counter = 0;

$increment = function () use ($counter) {
    $counter++;
    echo $counter;
};

$increment();        // 1
echo $counter;       // 0 (снаружи не изменилось)
```

### Захват по ссылке (`&`)

```php
$counter = 0;

$increment = function () use (&$counter) {
    $counter++;
    echo $counter;
};

$increment();        // 1
echo $counter;       // 1 (изменилось)
```

### Момент захвата

Переменные захватываются в момент создания замыкания:

```php
$x = 10;
$fn = function () use ($x) { return $x; };
$x = 20;
echo $fn();   // 10
```

### `use` с трейлинг-запятой (PHP 8.0+)

```php
$fn = function () use ($a, $b,) { ... };
```

### static-замыкания

Замыкание без привязки к `$this`:

```php
$fn = static function () {
    // $this недоступен
};
```

---

## Стрелочные функции (PHP 7.4+)

Стрелочные функции — лаконичный синтаксис анонимных функций:

```php
$fn = fn($x) => $x * 2;
```

Особенности:

- автоматически захватывают переменные родительской области без `use`;
- захват только по значению (нельзя по ссылке);
- одно выражение, которое возвращается;
- не поддерживают многострочные выражения.

```php
$factor = 10;
$numbers = [1, 2, 3];

$result = array_map(fn($n) => $n * $factor, $numbers);
// [10, 20, 30]
```

---

## Функции обратного вызова (callback)

Callback — функция, переданная другой функции и вызываемая внутри неё:

```php
$numbers = [1, 2, 3, 4];

$even = array_filter($numbers, fn($n) => $n % 2 === 0);
// [2, 4]

$squared = array_map(fn($n) => $n * $n, $numbers);
// [1, 4, 9, 16]
```

## Тип `callable`

`callable` — псевдотип, принимающий:

| Тип | Пример |
| --- | --- |
| Строка с именем функции | `'strlen'` |
| Массив [объект, метод] | `[$obj, 'method']` |
| Массив [класс, статический метод] | `['Foo', 'bar']` |
| Замыкание | `function () {}` |
| Объект с `__invoke()` | `new Invokable()` |

```php
function apply(callable $fn, $value)
{
    return $fn($value);
}

echo apply('strtoupper', 'hello');   // HELLO
```

---

## First-class callable syntax (PHP 8.1+)

Создание `Closure` из любой callable:

```php
$strlen = strlen(...);
$upper = strtoupper(...);
$method = $object->method(...);

echo $strlen('Hello');   // 5
echo $upper('hello');    // HELLO
```

---

## `$this` в замыканиях

Начиная с PHP 5.4, `$this` доступен в замыканиях, объявленных
внутри методов класса, без `use`.

```php
class Foo {
    private string $bar = 'baz';

    public function getClosure(): Closure
    {
        return function () {
            return $this->bar;   // $this доступен
        };
    }
}

$foo = new Foo();
$fn = $foo->getClosure();
echo $fn();   // baz
```

---

## `Closure::bind()` и `Closure::call()`

Привязка замыкания к объекту:

```php
class Foo {
    private string $bar = 'baz';
}

$fn = function () { return $this->bar; };
$bound = Closure::bind($fn, new Foo(), Foo::class);
echo $bound();   // baz
```

---

## Практические примеры

Стрелочная функция в `usort`:

```php
$users = [
    ['name' => 'Bob', 'age' => 30],
    ['name' => 'Alice', 'age' => 25],
];

usort($users, fn($a, $b) => $a['age'] <=> $b['age']);
```

Возврат замыкания:

```php
function multiplier(int $factor): Closure
{
    return fn($n) => $n * $factor;
}

$double = multiplier(2);
echo $double(5);   // 10
```

---

## Краткие итоги

- **Переменные функции** — вызов через `$fn()`, проверка через `is_callable()`.
- **Анонимные функции** — без имени, с `;`.
- **Замыкания** — захват переменных через `use`, по значению или по ссылке.
- **Стрелочные функции** — `fn() =>`, автоматический захват, одно выражение.
- **`callable`** — тип для callback.
- **First-class callable** — `strlen(...)` (PHP 8.1+).