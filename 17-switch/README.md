# Оператор switch в PHP 8

> Учебное пособие по PHP 8 · [Видеоурок](https://www.youtube.com/watch?v=egDgLO8kvtI&list=PLr3d3QYzkw2xabQRUpcZ_IBk9W50M9pe-&index=18&pp=iAQB)

Этот урок — туториал по оператору `switch` в PHP 8 и его сравнению с `if/else` и `match`.

## Как работает `switch`

`switch` сравнивает одно выражение с несколькими значениями и выполняет соответствующий блок кода:

```php
switch ($status) {
    case 'pending':
        echo 'Ожидает оплаты';
        break;
    case 'paid':
        echo 'Оплачено';
        break;
    case 'refunded':
        echo 'Возврат средств';
        break;
    default:
        echo 'Неизвестный статус';
}
```

Ключевые особенности:

- выражение вычисляется **один раз**;
- сравнение **нестрогое** (`==`), а не строгое (`===`);
- `break` завершает выполнение `switch`;
- `default` необязателен, но рекомендуется завершать его через `break`.

## Роль `break`

Без `break` происходит **fall-through** — выполнение продолжается со следующего `case`:

```php
$x = 1;

switch ($x) {
    case 1:
        echo 'Один';
        // break забыт!
    case 2:
        echo 'Два или больше';
        break;
}
// Вывод: «ОдинДва или больше»
```

**Намеренное fall-through** (когда это осознанно):

```php
switch ($level) {
    case 1:
    case 2:
        echo 'Начальный уровень';
        break;
    case 3:
    case 4:
        echo 'Средний уровень';
        break;
}
```

## `switch` внутри цикла

- `break` выходит только из `switch`, не из цикла;
- `break 2` выходит из `switch` и из одного уровня цикла;
- `continue` внутри `switch` работает как `break` — это ключевое отличие PHP от C, Java, JavaScript;
- чтобы пропустить итерацию внешнего цикла, используй `continue 2`.

```php
foreach ($items as $item) {
    switch ($item['type']) {
        case 'skip':
            continue;      // Как break — выходит из switch
        case 'stop':
            continue 2;    // Пропускает итерацию foreach
    }
}
```

## Разница между `switch` и `if/else`

| Характеристика | `switch` | `if/else` |
| --- | --- | --- |
| **Вычисление выражения** | Один раз | Для каждого условия |
| **Сравнение** | Нестрогое (`==`) | Любое |
| **Читаемость** | Лучше при множестве проверок | Лучше при сложных условиях |
| **Производительность** | Чуть быстрее при ресурсоёмком выражении | — |

## Изменения в PHP 8.0

В PHP 8.0 изменилось поведение сравнения строк и чисел:

```php
// PHP 7: 'Zero'
// PHP 8: 'Not zero'
switch ('') {
    case 0:
        echo 'Zero';
        break;
    default:
        echo 'Not zero';
}
```

## Альтернативный синтаксис

```php
<?php switch ($status): ?>
    <?php case 'paid': ?>
        <span class="paid">Оплачено</span>
        <?php break; ?>
    <?php case 'pending': ?>
        <span class="pending">Ожидает</span>
        <?php break; ?>
    <?php default: ?>
        <span class="unknown">Неизвестно</span>
<?php endswitch; ?>
```

**Важно:** любой вывод (включая пробелы) между `switch (...)` и первым `case` вызовет синтаксическую ошибку. Между `switch (...):` и первым case не допускается никакой вывод (пробелы, переводы строк, HTML). Это отличает `switch` от других альтернативных синтаксисов. Первый case должен находиться в том же PHP-блоке, что и `switch (...):`.

## `match` — современная альтернатива (PHP 8.0+)

```php
$result = match ($status) {
    'paid' => 'Оплачено',
    'pending' => 'Ожидает',
    default => 'Неизвестно',
};
```

| Характеристика | `switch` | `match` |
| --- | --- | --- |
| **Сравнение** | Нестрогое (`==`) | Строгое (`===`) |
| **Возвращает значение** | Нет | Да |
| **Fall-through** | Да | Нет |
| **Обязательный `default`** | Нет | Да (если не все случаи покрыты) |
| **Без `break`** | Выполняет следующий `case` | Не требуется |

---

### Практика для урока 17: `17-switch/index.php`

```php
<?php
declare(strict_types=1);

/**
 * Урок 17: Оператор switch
 * Практика по switch, fall-through, break/continue, альтернативному синтаксису
 */

// 1. Базовый switch
echo "=== Базовый switch ===\n";
$status = 'paid';
switch ($status) {
    case 'pending':
        echo "Ожидает оплаты\n";
        break;
    case 'paid':
        echo "Оплачено\n";
        break;
    case 'refunded':
        echo "Возврат средств\n";
        break;
    case 'cancelled':
        echo "Отменён\n";
        break;
    default:
        echo "Неизвестный статус\n";
}

// 2. Fall-through — намеренный
echo "\n=== Намеренный fall-through ===\n";
$level = 2;
switch ($level) {
    case 1:
    case 2:
        echo "Начальный уровень\n";
        break;
    case 3:
    case 4:
        echo "Средний уровень\n";
        break;
    case 5:
        echo "Продвинутый уровень\n";
        break;
    default:
        echo "Неизвестный уровень\n";
}

// 3. Забытый break — демонстрация fall-through
echo "\n=== Забытый break ===\n";
$x = 1;
switch ($x) {
    case 1:
        echo "Один";
        // break забыт!
    case 2:
        echo " Два или больше";
        break;
}
echo "\n";

// 4. switch внутри цикла — break vs continue vs break 2
echo "\n=== switch внутри цикла ===\n";
$items = [
    ['type' => 'normal', 'value' => 'A'],
    ['type' => 'skip', 'value' => 'B'],
    ['type' => 'normal', 'value' => 'C'],
    ['type' => 'stop', 'value' => 'D'],
    ['type' => 'normal', 'value' => 'E'],
];

foreach ($items as $item) {
    switch ($item['type']) {
        case 'skip':
            continue;      // выходит из switch, итерация foreach продолжается
        case 'stop':
            break 2;        // выходит из switch И из foreach
        case 'normal':
            echo "Обработано: {$item['value']}\n";
            break;
    }
}

// 5. Нестрогое сравнение в switch
echo "\n=== Нестрогое сравнение ===\n";
$value = 1;
switch ($value) {
    case '1':
        echo "Совпало со строкой '1' (нестрогое сравнение)\n";
        break;
    case true:
        echo "Совпало с true (нестрогое сравнение)\n";
        break;
    default:
        echo "Не совпало\n";
}

// 6. PHP 8: сравнение строк и чисел
echo "\n=== PHP 8: сравнение строк и чисел ===\n";
switch ('') {
    case 0:
        echo "Пустая строка совпала с 0 (PHP 7)\n";
        break;
    default:
        echo "Пустая строка не совпала с 0 (PHP 8+)\n";
}

// 7. Альтернативный синтаксис (для HTML)
echo "\n=== Альтернативный синтаксис ===\n";
$role = 'admin';
?>
<?php switch ($role): ?>
    <?php case 'admin': ?>
        <p>Панель администратора</p>
        <?php break; ?>
    <?php case 'user': ?>
        <p>Пользовательская страница</p>
        <?php break; ?>
    <?php default: ?>
        <p>Гостевая страница</p>
<?php endswitch; ?>
<?php

// 8. switch vs match
echo "\n=== switch vs match ===\n";
$statusCode = 404;

// switch
$message = '';
switch ($statusCode) {
    case 200:
        $message = 'OK';
        break;
    case 404:
        $message = 'Not Found';
        break;
    case 500:
        $message = 'Server Error';
        break;
    default:
        $message = 'Unknown';
}
echo "switch: $statusCode → $message\n";

// match — то же самое, но короче и строже
$message = match ($statusCode) {
    200 => 'OK',
    404 => 'Not Found',
    500 => 'Server Error',
    default => 'Unknown',
};
echo "match: $statusCode → $message\n";
```