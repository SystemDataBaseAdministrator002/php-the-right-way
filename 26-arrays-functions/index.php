<?php

declare(strict_types=1);

/**
 * Урок 26 — Функции для работы с массивами.
 *
 * Практика: фильтрация, преобразование, сортировка,
 * извлечение данных, агрегация, новые функции PHP 8.4.
 *
 * Открой в браузере:
 * http://localhost/php-the-right-way/26-arrays-functions/
 */

// ---------------------------------------------------------------------
// 1. array_filter.
// ---------------------------------------------------------------------

echo '<h3>1. array_filter</h3>';

$numbers = [1, 2, 3, 4, 5, 6, 7, 8];

$even = array_filter($numbers, fn($n) => $n % 2 === 0);
echo 'Чётные: ' . implode(', ', $even) . '<br>';   // 2, 4, 6, 8

// Без callback — удаляет falsy.
$data = [0, 1, 2, null, '', 3, false];
$withoutFalsy = array_filter($data);
echo 'Без falsy: ' . implode(', ', $withoutFalsy) . '<br>';   // 1, 2, 3

// ---------------------------------------------------------------------
// 2. array_map.
// ---------------------------------------------------------------------

echo '<h3>2. array_map</h3>';

$squared = array_map(fn($n) => $n ** 2, $numbers);
echo 'Квадраты: ' . implode(', ', $squared) . '<br>';

// С несколькими массивами.
$a = [1, 2, 3];
$b = [10, 20, 30];
$sums = array_map(fn($x, $y) => $x + $y, $a, $b);
echo 'Суммы: ' . implode(', ', $sums) . '<br>';   // 11, 22, 33

// ---------------------------------------------------------------------
// 3. array_reduce.
// ---------------------------------------------------------------------

echo '<h3>3. array_reduce</h3>';

$sum = array_reduce($numbers, fn($carry, $n) => $carry + $n, 0);
echo 'Сумма: ' . $sum . '<br>';   // 36

$product = array_reduce([1, 2, 3, 4], fn($carry, $n) => $carry * $n, 1);
echo 'Произведение: ' . $product . '<br>';   // 24

// ---------------------------------------------------------------------
// 4. array_walk.
// ---------------------------------------------------------------------

echo '<h3>4. array_walk</h3>';

$fruits = ['apple', 'banana', 'cherry'];
array_walk($fruits, function (&$value, $key) {
    $value = strtoupper($value) . " ($key)";
});
echo '<pre>';
print_r($fruits);
echo '</pre>';

// ---------------------------------------------------------------------
// 5. Сортировка.
// ---------------------------------------------------------------------

echo '<h3>5. Сортировка</h3>';

$fruits = ['banana', 'apple', 'cherry'];
sort($fruits);
echo 'sort: ' . implode(', ', $fruits) . '<br>';   // apple, banana, cherry

$fruits = ['banana', 'apple', 'cherry'];
rsort($fruits);
echo 'rsort: ' . implode(', ', $fruits) . '<br>';   // cherry, banana, apple

$ages = ['Bob' => 30, 'Alice' => 25, 'Charlie' => 35];
asort($ages);
echo 'asort: ';
print_r($ages);
echo '<br>';

// ---------------------------------------------------------------------
// 6. Пользовательская сортировка.
// ---------------------------------------------------------------------

echo '<h3>6. usort</h3>';

$users = [
    ['name' => 'Bob', 'age' => 30],
    ['name' => 'Alice', 'age' => 25],
    ['name' => 'Charlie', 'age' => 35],
];

usort($users, fn($a, $b) => $a['age'] <=> $b['age']);

echo '<pre>';
print_r($users);
echo '</pre>';

// ---------------------------------------------------------------------
// 7. array_column.
// ---------------------------------------------------------------------

echo '<h3>7. array_column</h3>';

$records = [
    ['id' => 1, 'name' => 'Alice', 'email' => 'alice@example.com'],
    ['id' => 2, 'name' => 'Bob', 'email' => 'bob@example.com'],
    ['id' => 3, 'name' => 'Charlie', 'email' => 'charlie@example.com'],
];

$names = array_column($records, 'name');
echo 'Имена: ' . implode(', ', $names) . '<br>';

$byId = array_column($records, 'name', 'id');
echo '<pre>';
print_r($byId);
echo '</pre>';

// ---------------------------------------------------------------------
// 8. array_slice и array_chunk.
// ---------------------------------------------------------------------

echo '<h3>8. array_slice / array_chunk</h3>';

$array = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

$slice = array_slice($array, 2, 4);
echo 'slice(2, 4): ' . implode(', ', $slice) . '<br>';   // 3, 4, 5, 6

$chunks = array_chunk($array, 3);
echo 'chunk(3): <pre>';
print_r($chunks);
echo '</pre>';

// ---------------------------------------------------------------------
// 9. Множества.
// ---------------------------------------------------------------------

echo '<h3>9. Множества</h3>';

$a = [1, 2, 3, 4];
$b = [3, 4, 5, 6];

echo 'diff: ' . implode(', ', array_diff($a, $b)) . '<br>';           // 1, 2
echo 'intersect: ' . implode(', ', array_intersect($a, $b)) . '<br>'; // 3, 4
echo 'unique: ' . implode(', ', array_unique([1, 2, 2, 3, 3])) . '<br>'; // 1, 2, 3
echo 'merge: ' . implode(', ', array_merge($a, $b)) . '<br>';

// ---------------------------------------------------------------------
// 10. Агрегация.
// ---------------------------------------------------------------------

echo '<h3>10. Агрегация</h3>';

$values = [1, 2, 3, 4, 5];
echo 'count: ' . count($values) . '<br>';
echo 'sum: ' . array_sum($values) . '<br>';
echo 'product: ' . array_product($values) . '<br>';

$counts = array_count_values(['a', 'b', 'a', 'c', 'b', 'a']);
echo '<pre>';
print_r($counts);
echo '</pre>';

// ---------------------------------------------------------------------
// 11. Новые функции PHP 8.4.
// ---------------------------------------------------------------------

echo '<h3>11. PHP 8.4: array_find, array_any, array_all</h3>';

$users = [
    ['name' => 'Alice', 'active' => false],
    ['name' => 'Bob', 'active' => true],
    ['name' => 'Charlie', 'active' => true],
];

if (function_exists('array_find')) {
    $firstActive = array_find($users, fn($u) => $u['active']);
    echo 'array_find: ' . $firstActive['name'] . '<br>';

    $firstActiveKey = array_find_key($users, fn($u) => $u['active']);
    echo 'array_find_key: ' . $firstActiveKey . '<br>';

    $hasActive = array_any($users, fn($u) => $u['active']);
    echo 'array_any: ' . var_export($hasActive, true) . '<br>';

    $allActive = array_all($users, fn($u) => $u['active']);
    echo 'array_all: ' . var_export($allActive, true) . '<br>';
} else {
    echo 'PHP 8.4 не установлен. Новые функции недоступны.<br>';
    echo 'Эмуляция через array_filter:<br>';

    $firstActive = array_values(array_filter($users, fn($u) => $u['active']))[0] ?? null;
    echo 'array_find: ' . ($firstActive['name'] ?? 'не найдено') . '<br>';
}

// ---------------------------------------------------------------------
// 12. Цепочки функций.
// ---------------------------------------------------------------------

echo '<h3>12. Цепочки</h3>';

$products = [
    ['name' => 'Laptop', 'price' => 1000, 'inStock' => true],
    ['name' => 'Phone', 'price' => 500, 'inStock' => false],
    ['name' => 'Tablet', 'price' => 300, 'inStock' => true],
    ['name' => 'Monitor', 'price' => 200, 'inStock' => true],
];

// Названия товаров в наличии, дороже 250:
$result = array_map(
    fn($p) => $p['name'],
    array_filter($products, fn($p) => $p['inStock'] && $p['price'] > 250)
);

echo 'В наличии и дороже 250: ' . implode(', ', $result) . '<br>';

// Сортировка по цене.
usort($products, fn($a, $b) => $a['price'] <=> $b['price']);
echo 'Сортировка по цене: ';
foreach ($products as $p) {
    echo $p['name'] . ' (' . $p['price'] . ') ';
}

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;