# Функции для работы с массивами в PHP 8

> Учебное пособие по PHP 8 · [Видеоурок](https://www.youtube.com/watch?v=E4FUeWa3WQk&list=PLr3d3QYzkw2xabQRUpcZ_IBk9W50M9pe-&index=27&pp=iAQB)

Этот урок — обзорная систематизация функций для работы с массивами в PHP 8.

## Зачем нужны встроенные функции

Массивы — основа PHP. В стандартной библиотеке более **80 функций** только для массивов. Использование встроенных функций вместо ручных `foreach`-циклов даёт:

- **Читаемость** — `array_filter($users, fn($u) => $u->isActive())` понятнее, чем цикл с `if` и `$result[]`.
- **Производительность** — реализация на C быстрее интерпретируемого PHP-кода.
- **Меньше ошибок** — не нужно следить за переиндексацией, `break`, мутацией исходного массива.

**Правило:** сначала используй встроенную функцию, оптимизацию откладывай до профилирования.

---

## Категории функций

| Категория | Ключевые функции |
|---|---|
| **Создание и заполнение** | `array_fill()`, `array_fill_keys()`, `range()`, `array_combine()` |
| **Добавление и удаление** | `array_push()`, `array_pop()`, `array_shift()`, `array_unshift()`, `array_splice()` |
| **Доступ и поиск** | `in_array()`, `array_search()`, `array_key_exists()`, `array_keys()`, `array_values()` |
| **Фильтрация и преобразование** | `array_filter()`, `array_map()`, `array_reduce()`, `array_walk()` |
| **Сортировка** | `sort()`, `rsort()`, `asort()`, `ksort()`, `usort()`, `uasort()`, `uksort()`, `array_multisort()` |
| **Извлечение данных** | `array_column()`, `array_slice()`, `array_chunk()`, `array_flip()` |
| **Множества** | `array_diff()`, `array_intersect()`, `array_unique()`, `array_merge()` |
| **Агрегация** | `array_sum()`, `array_product()`, `array_count_values()` |
| **Новое в PHP 8.4** | `array_find()`, `array_find_key()`, `array_any()`, `array_all()` |

---

## Фильтрация, преобразование, свёртка

### `array_filter()`

Оставляет элементы, для которых callback вернул `true`:

```php
$numbers = [1, 2, 3, 4, 5, 6];
$even = array_filter($numbers, fn($n) => $n % 2 === 0);
// [1 => 2, 3 => 4, 5 => 6] — ключи сохраняются
```

Важно: без callback `array_filter()` удаляет все falsy-значения (`0`, `''`, `null`, `false`, `[]`). Всегда передавай явный predicate:

```php
$data = [0, 1, 2, null, '', 3];
$filtered = array_filter($data, fn($v) => $v !== null);
// [0 => 0, 1 => 1, 2 => 2, 4 => '', 5 => 3]
```

### `array_map()`

Применяет callback к каждому элементу и возвращает новый массив:

```php
$numbers = [1, 2, 3, 4];
$squared = array_map(fn($n) => $n * $n, $numbers);
// [1, 4, 9, 16]
```

С несколькими массивами:

```php
$a = [1, 2, 3];
$b = [10, 20, 30];
$sums = array_map(fn($x, $y) => $x + $y, $a, $b);
// [11, 22, 33]
```

### `array_reduce()`

Свёртка массива в одно значение:

```php
$numbers = [1, 2, 3, 4, 5];
$sum = array_reduce($numbers, fn($carry, $n) => $carry + $n, 0);
// 15
```

### `array_walk()`

Применяет callback к каждому элементу по ссылке (изменяет исходный массив):

```php
$fruits = ['apple', 'banana'];
array_walk($fruits, function (&$value, $key) {
    $value = strtoupper($value);
});
// ['APPLE', 'BANANA']
```

---

## Сортировка

### Простая сортировка

| Функция | Сортирует по | Сохраняет ключи | Порядок |
|---|---|---|---|
| `sort()` | Значению | Нет | Возрастание |
| `rsort()` | Значению | Нет | Убывание |
| `asort()` | Значению | Да | Возрастание |
| `arsort()` | Значению | Да | Убывание |
| `ksort()` | Ключу | Да | Возрастание |
| `krsort()` | Ключу | Да | Убывание |

```php
$fruits = ['banana', 'apple', 'cherry'];
sort($fruits);   // ['apple', 'banana', 'cherry']
```

### Пользовательская сортировка

| Функция | Сравнивает | Сохраняет ключи |
|---|---|---|
| `usort()` | Значения | Нет |
| `uasort()` | Значения | Да |
| `uksort()` | Ключи | Да |

```php
$users = [
    ['name' => 'Bob', 'age' => 30],
    ['name' => 'Alice', 'age' => 25],
];

usort($users, fn($a, $b) => $a['age'] <=> $b['age']);
// Alice (25), Bob (30)
```

### `array_multisort()`

Сортировка по нескольким критериям:

```php
$names = ['Bob', 'Alice', 'Charlie'];
$ages = [30, 25, 35];

array_multisort($ages, SORT_ASC, $names);
// Alice (25), Bob (30), Charlie (35)
```

---

## Извлечение данных

### `array_column()`

Извлекает значения одного столбца из массива массивов:

```php
$users = [
    ['id' => 1, 'name' => 'Alice'],
    ['id' => 2, 'name' => 'Bob'],
];

$names = array_column($users, 'name');
// ['Alice', 'Bob']

// С индексацией по id:
$byId = array_column($users, 'name', 'id');
// [1 => 'Alice', 2 => 'Bob']

// Весь элемент, индексированный по id:
$indexed = array_column($users, null, 'id');
// [1 => [...], 2 => [...]]
```

### `array_slice()`

Извлекает часть массива:

```php
$array = [1, 2, 3, 4, 5];
$slice = array_slice($array, 1, 3);
// [2, 3, 4]
```

### `array_chunk()`

Разбивает на части:

```php
$array = [1, 2, 3, 4, 5];
$chunks = array_chunk($array, 2);
// [[1, 2], [3, 4], [5]]
```

---

## Множества

```php
$a = [1, 2, 3, 4];
$b = [3, 4, 5, 6];

array_diff($a, $b);       // [1, 2] — есть в $a, но нет в $b
array_intersect($a, $b);  // [3, 4] — есть в обоих
array_unique([1, 2, 2, 3]); // [1, 2, 3]
array_merge($a, $b);      // [1, 2, 3, 4, 3, 4, 5, 6]
```

---

## Новое в PHP 8.4

Четыре новые функции для декларативной работы с массивами:

### `array_find()`

Возвращает первый элемент, удовлетворяющий условию, или `null`:

```php
$users = [
    ['name' => 'Alice', 'active' => false],
    ['name' => 'Bob', 'active' => true],
    ['name' => 'Charlie', 'active' => true],
];

$firstActive = array_find($users, fn($u) => $u['active']);
// ['name' => 'Bob', 'active' => true]
```

### `array_find_key()`

Возвращает ключ первого подходящего элемента:

```php
$key = array_find_key($users, fn($u) => $u['active']);
// 1
```

### `array_any()`

Возвращает `true`, если хотя бы один элемент удовлетворяет условию:

```php
$hasActive = array_any($users, fn($u) => $u['active']);
// true
```

### `array_all()`

Возвращает `true`, если все элементы удовлетворяют условию:

```php
$allActive = array_all($users, fn($u) => $u['active']);
// false
```

---

## Полезные функции

| Функция | Описание |
|---|---|
| `count()` | Количество элементов |
| `array_sum()` | Сумма значений |
| `array_product()` | Произведение значений |
| `array_count_values()` | Частота каждого значения |
| `in_array()` | Проверка значения |
| `array_search()` | Поиск ключа по значению |
| `array_flip()` | Меняет ключи и значения местами |
| `array_reverse()` | Обратный порядок |
| `range()` | Генерация диапазона |
| `array_is_list()` (PHP 8.1) | Проверка, является ли массив списком |

---

## Практика: цепочки функций

```php
$users = [
    ['name' => 'Alice', 'age' => 25, 'active' => true],
    ['name' => 'Bob', 'age' => 30, 'active' => false],
    ['name' => 'Charlie', 'age' => 35, 'active' => true],
];

// Имена активных пользователей старше 26 лет:
$names = array_map(
    fn($u) => $u['name'],
    array_filter($users, fn($u) => $u['active'] && $u['age'] > 26)
);
// ['Charlie']
```

---

## Практические задачи

Создай файл `index.php` и реши задачи:

1. Дан массив `[3, 1, 4, 1, 5, 9, 2, 6]`. Отсортируй по убыванию и удали дубликаты.
2. Дан массив пользователей `[ ['name' => 'Alice', 'age' => 25], ['name' => 'Bob', 'age' => 30] ]`. Получи массив имён с помощью `array_column`.
3. Дан массив `[1, 2, 3, 4, 5, 6, 7, 8, 9, 10]`. Оставь только чётные числа и умножь каждое на 10.
4. Дан массив `['apple', 'banana', 'cherry', 'date']`. Получи строку `APPLE, BANANA, CHERRY, DATE` с помощью `array_map` и `implode`.
5. Дан массив чисел. Вычисли произведение всех элементов через `array_reduce`.
6. Дан массив `[ ['id' => 1, 'name' => 'A'], ['id' => 2, 'name' => 'B'] ]`. Индексируй по `id` с помощью `array_column`.
7. Даны два массива: `[1, 2, 3]` и `[3, 4, 5]`. Найди пересечение и разность.
8. Дан массив пользователей. Найди первого активного с помощью `array_find` (PHP 8.4).

---

## Краткие итоги

- Встроенные функции предпочтительнее ручных `foreach`-циклов.
- `array_filter`, `array_map`, `array_reduce` — основа функциональной обработки.
- `array_column` — извлечение столбца из массива массивов.
- `usort` с `<=>` — сортировка по любому критерию.
- PHP 8.4 добавил `array_find`, `array_find_key`, `array_any`, `array_all`.
- Всегда профилируй перед оптимизацией — читаемость важнее.