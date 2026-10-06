<?php

declare(strict_types=1);

/**
 * Урок 25 — Даты и часовые пояса.
 *
 * Практика: time(), date(), DateTimeImmutable, DateTimeZone,
 * createFromFormat, DateInterval, DatePeriod.
 *
 * Открой в браузере:
 * http://localhost/php-the-right-way/25-dates-timezones/
 */

// ---------------------------------------------------------------------
// 1. Временная метка Unix.
// ---------------------------------------------------------------------

echo '<h3>1. Метка Unix</h3>';

$now = time();
echo 'Сейчас: ' . $now . '<br>';
echo 'Завтра: ' . ($now + 86400) . '<br>';
echo '5 дней: ' . ($now + 5 * 86400) . '<br>';

// ---------------------------------------------------------------------
// 2. Форматирование date().
// ---------------------------------------------------------------------

echo '<h3>2. date()</h3>';

echo date('Y-m-d H:i:s') . '<br>';
echo date('D, d M Y') . '<br>';
echo date('l, F j, Y') . '<br>';

// ---------------------------------------------------------------------
// 3. Часовые пояса.
// ---------------------------------------------------------------------

echo '<h3>3. Часовые пояса</h3>';

// По умолчанию.
echo 'Default TZ: ' . date_default_timezone_get() . '<br>';

// Устанавливаем UTC.
date_default_timezone_set('UTC');
echo 'После set: ' . date_default_timezone_get() . '<br>';
echo 'UTC time: ' . date('Y-m-d H:i:s') . '<br>';

// Восстанавливаем.
date_default_timezone_set('Europe/Moscow');
echo 'Moscow time: ' . date('Y-m-d H:i:s') . '<br>';

// ---------------------------------------------------------------------
// 4. DateTimeImmutable.
// ---------------------------------------------------------------------

echo '<h3>4. DateTimeImmutable</h3>';

$date = new DateTimeImmutable('2023-12-25 15:30:00', new DateTimeZone('UTC'));

echo 'Format: ' . $date->format('Y-m-d H:i:s') . '<br>';
echo 'Timestamp: ' . $date->getTimestamp() . '<br>';

// Смена пояса.
$moscow = $date->setTimezone(new DateTimeZone('Europe/Moscow'));
echo 'Moscow: ' . $moscow->format('Y-m-d H:i:s') . '<br>';

// ---------------------------------------------------------------------
// 5. DateTimeZone.
// ---------------------------------------------------------------------

echo '<h3>5. DateTimeZone</h3>';

$utc = new DateTimeZone('UTC');
$moscow = new DateTimeZone('Europe/Moscow');

$date = new DateTimeImmutable('now', $utc);
echo 'UTC: ' . $date->format('Y-m-d H:i:s') . '<br>';
echo 'Moscow: ' . $date->setTimezone($moscow)->format('Y-m-d H:i:s') . '<br>';

// ---------------------------------------------------------------------
// 6. createFromFormat.
// ---------------------------------------------------------------------

echo '<h3>6. createFromFormat</h3>';

$date = DateTimeImmutable::createFromFormat('d.m.Y H:i', '25.12.2023 15:30');

if ($date === false) {
    echo 'Ошибка парсинга<br>';
} else {
    echo 'Parsed: ' . $date->format('Y-m-d H:i:s') . '<br>';
    echo 'Timestamp: ' . $date->getTimestamp() . '<br>';
}

// ---------------------------------------------------------------------
// 7. strtotime.
// ---------------------------------------------------------------------

echo '<h3>7. strtotime</h3>';

$dates = [
    '2023-12-25',
    '+3 days',
    'next Monday',
    '2023-12-25 15:30:00 Europe/Moscow',
];

foreach ($dates as $str) {
    $ts = strtotime($str);
    echo "$str → " . date('Y-m-d H:i:s', $ts) . '<br>';
}

// ---------------------------------------------------------------------
// 8. date_parse_from_format + mktime.
// ---------------------------------------------------------------------

echo '<h3>8. date_parse_from_format + mktime</h3>';

$parsed = date_parse_from_format('d.m.Y H:i', '25.12.2023 15:30');

if ($parsed['error_count'] === 0) {
    $ts = mktime(
        $parsed['hour'],
        $parsed['minute'],
        $parsed['second'],
        $parsed['month'],
        $parsed['day'],
        $parsed['year']
    );
    echo 'Timestamp: ' . $ts . '<br>';
} else {
    echo 'Ошибки: ' . $parsed['error_count'] . '<br>';
}

// ---------------------------------------------------------------------
// 9. DateInterval.
// ---------------------------------------------------------------------

echo '<h3>9. DateInterval</h3>';

$date = new DateTimeImmutable('2023-12-25');
$nextWeek = $date->add(new DateInterval('P7D'));
$nextMonth = $date->add(new DateInterval('P1M'));
$twoHours = $date->add(new DateInterval('PT2H'));

echo 'Date: ' . $date->format('Y-m-d') . '<br>';
echo 'Next week: ' . $nextWeek->format('Y-m-d') . '<br>';
echo 'Next month: ' . $nextMonth->format('Y-m-d') . '<br>';

// ---------------------------------------------------------------------
// 10. DatePeriod.
// ---------------------------------------------------------------------

echo '<h3>10. DatePeriod</h3>';

$start = new DateTimeImmutable('2023-01-01');
$end = new DateTimeImmutable('2023-01-05');
$period = new DatePeriod($start, new DateInterval('P1D'), $end);

foreach ($period as $date) {
    echo $date->format('Y-m-d') . '<br>';
}

// ---------------------------------------------------------------------
// 11. Практический пример: возраст.
// ---------------------------------------------------------------------

echo '<h3>11. Возраст</h3>';

$birthday = new DateTimeImmutable('1990-05-15');
$now = new DateTimeImmutable('now');
$age = $birthday->diff($now);

echo 'Возраст: ' . $age->y . ' лет, ' . $age->m . ' месяцев<br>';

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;