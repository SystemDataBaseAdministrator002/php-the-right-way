<?php

declare(strict_types=1);

/**
 * Урок 09 — Тип данных Null.
 *
 * Практика: создание null, проверка, преобразование,
 * операторы ?? и ?->, nullable types.
 *
 * Открой в браузере:
 * http://localhost/php-the-right-way/09-null/
 */

// ---------------------------------------------------------------------
// 1. Три случая, когда переменная становится null.
// ---------------------------------------------------------------------

echo '<h3>1. Три случая null</h3>';

$a = null;                  // присвоено

// $b не определена — при обращении Warning, значение null.

$c = 'value';
unset($c);                  // удалена

var_dump($a);               // NULL
var_dump($c ?? 'удалена');  // string 'удалена'
echo '<br>';

// ---------------------------------------------------------------------
// 2. Проверка null.
// ---------------------------------------------------------------------

echo '<h3>2. Проверка null</h3>';
echo '<pre>';

$var = null;

var_dump(is_null($var));       // bool(true)
var_dump($var === null);       // bool(true)
var_dump(isset($var));         // bool(false) — isset считает null отсутствием
var_dump(empty($var));         // bool(true)

echo '</pre>';

// ---------------------------------------------------------------------
// 3. Преобразование null.
// ---------------------------------------------------------------------

echo '<h3>3. Преобразование null</h3>';
echo '<pre>';

var_dump((string) null);    // string(0) ""
var_dump((int) null);       // int(0)
var_dump((float) null);     // float(0)
var_dump((bool) null);      // bool(false)
var_dump((array) null);     // array(0) {}

// Сравнение с false.
var_dump((string) false);   // string(1) "0"
var_dump((string) null);    // string(0) ""

echo '</pre>';

// ---------------------------------------------------------------------
// 4. Оператор ?? (null coalescing).
// ---------------------------------------------------------------------

echo '<h3>4. Оператор ??</h3>';

$_GET['username'] = 'Gio';

$username = $_GET['username'] ?? 'nobody';
echo 'username: ' . $username . '<br>';   // Gio

$page = $_GET['page'] ?? 1;
echo 'page: ' . $page . '<br>';           // 1 (значение по умолчанию)

// Цепочка.
$config = null;
$default = $config ?? $_GET['theme'] ?? 'light';
echo 'theme: ' . $default . '<br>';       // light

// ---------------------------------------------------------------------
// 5. Оператор ?-> (nullsafe) — PHP 8.0+.
// ---------------------------------------------------------------------

echo '<h3>5. Оператор ?-> (nullsafe)</h3>';

class User
{
    public ?Profile $profile = null;
}

class Profile
{
    public ?Address $address = null;
}

class Address
{
    public string $country = 'Russia';
}

$user = new User();
// $user->profile = new Profile();
// $user->profile->address = new Address();

// Без ?-> была бы фатальная ошибка.
$country = $user->profile?->address?->country ?? 'Unknown';
echo 'country: ' . $country . '<br>';   // Unknown

// Если заполнить:
$user->profile = new Profile();
$user->profile->address = new Address();
$country = $user->profile?->address?->country ?? 'Unknown';
echo 'country (заполнено): ' . $country . '<br>';   // Russia

// ---------------------------------------------------------------------
// 6. Nullable types (PHP 7.1+).
// ---------------------------------------------------------------------

echo '<h3>6. Nullable types</h3>';

function greet(?string $name): ?string
{
    return $name ? "Hello, {$name}" : null;
}

var_dump(greet('Gio'));    // string(9) "Hello, Gio"
var_dump(greet(null));     // NULL
echo '<br>';

// ---------------------------------------------------------------------
// 7. isset() vs array_key_exists().
// ---------------------------------------------------------------------

echo '<h3>7. isset() vs array_key_exists()</h3>';
echo '<pre>';

$array = ['key' => null];

var_dump(isset($array['key']));           // bool(false)
var_dump(array_key_exists('key', $array)); // bool(true)

echo '</pre>';

// ---------------------------------------------------------------------
// 8. match с null (PHP 8.0+).
// ---------------------------------------------------------------------

echo '<h3>8. match с null</h3>';

$value = null;

$result = match ($value) {
    null => 'Значение отсутствует',
    default => 'Значение есть',
};

echo $result . '<br>';   // Значение отсутствует

// ---------------------------------------------------------------------
// 9. Deprecation в PHP 8.1 (для демонстрации).
// ---------------------------------------------------------------------

echo '<h3>9. Deprecation в PHP 8.1</h3>';
echo 'Передача null в strlen() вызовет deprecation notice:<br>';

// Раскомментируй — увидишь Deprecated:
// strlen(null);

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;