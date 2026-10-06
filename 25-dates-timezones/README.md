# Работа с датами и часовыми поясами в PHP 8

> Учебное пособие по PHP 8 · [Видеоурок](https://www.youtube.com/watch?v=Zf9MWSUKpVM&list=PLr3d3QYzkw2xabQRUpcZ_IBk9W50M9pe-&index=26&pp=iAQB)

Этот урок — туториал по работе с датами и часовыми поясами в PHP 8.

## Временная метка Unix

`time()` возвращает количество секунд с 1 января 1970 года (UTC):

```php
$now = time();          // int
$tomorrow = $now + 86400;   // +1 день
$fiveDays = $now + 5 * 24 * 60 * 60;
```

Важно: метка времени не содержит информации о часовом поясе. Это всегда UTC.

---

## Форматирование даты

`date(string $format, ?int $timestamp = null): string`

```php
echo date('Y-m-d H:i:s');          // 2026-09-22 12:00:00
echo date('D, d M Y');             // Mon, 22 Sep 2026
echo date('Y-m-d', time() - 86400); // Вчера
```

Ключевые символы формата:

| Символ | Описание | Пример |
| --- | --- | --- |
| `d` | День месяца (01–31) | 22 |
| `D` | День недели (сокр.) | Mon |
| `m` | Месяц (01–12) | 09 |
| `M` | Месяц (сокр.) | Sep |
| `Y` | Год (4 цифры) | 2026 |
| `H` | Часы (00–23) | 12 |
| `i` | Минуты (00–59) | 00 |
| `s` | Секунды (00–59) | 00 |
| `U` | Unix-метка | 1758537600 |

---

## Часовые пояса

### Установка пояса по умолчанию

```php
date_default_timezone_set('UTC');
```

Рекомендация: устанавливай UTC в `php.ini` или через `date_default_timezone_set()`. Это упрощает работу с пользователями из разных регионов.

### Класс DateTimeZone

```php
$utc = new DateTimeZone('UTC');
$moscow = new DateTimeZone('Europe/Moscow');
```

---

## Современный подход: DateTimeImmutable

`DateTimeImmutable` — рекомендуемый класс (иммутабельный). `DateTime` изменяет сам объект, что может привести к багам.

```php
$date = new DateTimeImmutable('2023-12-25 15:30:00', new DateTimeZone('UTC'));

// Форматирование
echo $date->format('Y-m-d H:i:s');   // 2023-12-25 15:30:00

// Метка времени (всегда UTC)
echo $date->getTimestamp();

// Смена пояса (возвращает новый объект)
$moscow = $date->setTimezone(new DateTimeZone('Europe/Moscow'));
echo $moscow->format('Y-m-d H:i:s');   // 2023-12-25 18:30:00
```

---

## Парсинг строк

### DateTimeImmutable::createFromFormat() (рекомендуется)

```php
$date = DateTimeImmutable::createFromFormat('d.m.Y H:i', '25.12.2023 15:30');

if ($date === false) {
    echo 'Ошибка парсинга';
} else {
    echo $date->getTimestamp();
}
```

### strtotime() (для простых случаев)

```php
$timestamp = strtotime('2023-12-25');
$timestamp = strtotime('+3 days');
$timestamp = strtotime('next Monday');
$timestamp = strtotime('2023-12-25 15:30:00 Europe/Moscow');
```

Ограничения:

- Только английский язык.
- Возвращает `false` при ошибке.
- Использует часовой пояс по умолчанию.

### date_parse_from_format() + mktime() (устаревший)

```php
$parsed = date_parse_from_format('d.m.Y H:i', '25.12.2023 15:30');

if ($parsed['error_count'] === 0) {
    $timestamp = mktime(
        $parsed['hour'],
        $parsed['minute'],
        $parsed['second'],
        $parsed['month'],
        $parsed['day'],
        $parsed['year']
    );
}
```

Недостатки: использует локальный часовой пояс, многословно.

---

## Арифметика дат

### DateInterval

```php
$date = new DateTimeImmutable('2023-12-25');
$nextWeek = $date->add(new DateInterval('P7D'));

echo $nextWeek->format('Y-m-d');   // 2024-01-01
```

### DatePeriod

```php
$start = new DateTimeImmutable('2023-01-01');
$end = new DateTimeImmutable('2023-01-05');
$period = new DatePeriod($start, new DateInterval('P1D'), $end);

foreach ($period as $date) {
    echo $date->format('Y-m-d') . "\n";
}
```

---

## Сравнительная таблица

| Метод | Плюсы | Минусы | Когда использовать |
| --- | --- | --- | --- |
| `DateTimeImmutable` | Иммутабельность, часовые пояса, ООП | Сложнее | Рекомендуется |
| `strtotime()` | Простота, относительные даты | Только английский, нет поясов | Быстрые простые случаи |
| `DateTime::createFromFormat()` | Точный формат, пояс | — | Парсинг с известным форматом |
| `date_parse_from_format()` + `mktime()` | — | Многословно, локальный пояс | Устаревший подход |

---

## Deprecations

- **PHP 8.1**: `date_sunrise()` и `date_sunset()` — deprecated.
- **PHP 8.4**: константы `SUNFUNCS_RET_*` — deprecated.

---

## Краткие итоги

- `DateTimeImmutable` — современный класс для работы с датами.
- `DateTimeZone` — для часовых поясов.
- UTC — рекомендуемый пояс по умолчанию.
- `getTimestamp()` всегда возвращает UTC.
- `DateInterval` и `DatePeriod` — для арифметики и итерации.

---

## Практика

Создай файл `index.php` и выполни следующие задачи:

1. Выведи текущую дату в формате `d.m.Y H:i:s`.
2. Создай `DateTimeImmutable` для даты `2026-01-01 00:00:00` в UTC и выведи метку времени.
3. Преобразуй строку `15.08.2025 10:30` в `DateTimeImmutable` через `createFromFormat()`.
4. С помощью `strtotime()` получи метку времени для `next Friday` и выведи её через `date()`.
5. Прибавь 30 дней к текущей дате через `DateInterval` и выведи результат.
6. Создай `DatePeriod` с интервалом 1 неделя и выведи все даты за месяц.
7. Установи часовой пояс `Europe/Moscow`, выведи текущее время, затем переключи на `America/New_York` и выведи снова.
8. Сравни две даты: `2025-12-31` и `2026-01-01` — выведи, какая раньше.