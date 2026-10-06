<?php

declare(strict_types=1);

/**
 * Урок 16 — Циклы: while, do-while, for, foreach.
 * Операторы break и continue.
 *
 * Практика: все виды циклов, break, continue,
 * вложенные циклы, альтернативный синтаксис.
 *
 * Открой в браузере:
 * http://localhost/php-the-right-way/16-loops-break-continue/
 */

// ---------------------------------------------------------------------
// 1. Цикл while.
// ---------------------------------------------------------------------

echo '<h3>1. while</h3>';

$count = 1;

while ($count <= 5) {
    echo "Count: $count<br>";
    $count++;
}

// Бесконечный цикл с защитой.
$safety = 0;
while (true) {
    $safety++;
    if ($safety > 3) {
        echo 'Вышли из бесконечного цикла.<br>';
        break;
    }
}

// ---------------------------------------------------------------------
// 2. Цикл do-while.
// ---------------------------------------------------------------------

echo '<h3>2. do-while</h3>';

$start = 5;

do {
    echo "Start: $start<br>";
    $start++;
} while ($start < 8);

// Выполняется один раз, несмотря на ложное условие.
$i = 0;
do {
    echo "Выполнилось один раз: $i<br>";
} while ($i > 0);

// ---------------------------------------------------------------------
// 3. Цикл for.
// ---------------------------------------------------------------------

echo '<h3>3. for</h3>';

for ($i = 1; $i <= 5; $i++) {
    echo $i . ' ';
}
echo '<br>';

// Обратный отсчёт.
for ($i = 5; $i > 0; $i--) {
    echo "$i... ";
}
echo '<br>';

// Несколько выражений.
for ($i = 1, $j = 0; $i <= 5; $j += $i, $i++) {
    echo "i=$i, j=$j<br>";
}

// ---------------------------------------------------------------------
// 4. Цикл foreach.
// ---------------------------------------------------------------------

echo '<h3>4. foreach</h3>';

// Только значения.
$colors = ['red', 'blue', 'green'];

foreach ($colors as $color) {
    echo $color . '<br>';
}

// Ключ и значение.
$user = ['name' => 'Gio', 'age' => 30, 'email' => 'gio@example.com'];

foreach ($user as $key => $value) {
    echo "$key: $value<br>";
}

// Многомерный массив.
echo '<h4>Многомерный массив:</h4>';
$grid = [
    ['a', 'b', 'c'],
    ['d', 'e', 'f'],
];

foreach ($grid as $rowIndex => $row) {
    foreach ($row as $colIndex => $cell) {
        echo "grid[$rowIndex][$colIndex] = $cell<br>";
    }
}

// Деструктуризация (PHP 7.1+).
echo '<h4>Деструктуризация:</h4>';
$pairs = [[1, 2], [3, 4], [5, 6]];

foreach ($pairs as [$a, $b]) {
    echo "a=$a, b=$b<br>";
}

// ---------------------------------------------------------------------
// 5. Оператор break.
// ---------------------------------------------------------------------

echo '<h3>5. break</h3>';

for ($i = 1; $i <= 10; $i++) {
    if ($i == 5) {
        break;
    }
    echo $i . ' ';
}
echo '<br>После цикла.<br>';

// break с уровнем.
echo '<h4>break 2:</h4>';

for ($i = 0; $i < 3; $i++) {
    for ($j = 0; $j < 3; $j++) {
        if ($j == 1) {
            echo "Выход из обоих циклов (i=$i, j=$j)<br>";
            break 2;
        }
        echo "i=$i, j=$j<br>";
    }
}

// ---------------------------------------------------------------------
// 6. Оператор continue.
// ---------------------------------------------------------------------

echo '<h3>6. continue</h3>';

for ($i = 1; $i <= 10; $i++) {
    if ($i == 5) {
        continue;
    }
    echo $i . ' ';
}
echo '<br>';

// continue с уровнем.
echo '<h4>continue 2:</h4>';

for ($i = 1; $i <= 3; $i++) {
    for ($j = 1; $j <= 3; $j++) {
        if ($j == 2) {
            echo "Пропускаем j=2 для i=$i<br>";
            continue 2;
        }
        echo "i=$i, j=$j<br>";
    }
}

// ---------------------------------------------------------------------
// 7. Разница break и continue.
// ---------------------------------------------------------------------

echo '<h3>7. break vs continue</h3>';

echo '<h4>С break:</h4>';
$counter = 0;
while ($counter < 5) {
    $counter++;
    if ($counter == 3) {
        break;
    }
    echo "counter=$counter<br>";
}
echo 'После цикла (break).<br>';

echo '<h4>С continue:</h4>';
$counter = 0;
while ($counter < 5) {
    $counter++;
    if ($counter == 3) {
        continue;
    }
    echo "counter=$counter<br>";
}
echo 'После цикла (continue).<br>';

// ---------------------------------------------------------------------
// 8. Альтернативный синтаксис.
// ---------------------------------------------------------------------

echo '<h3>8. Альтернативный синтаксис</h3>';

$items = ['apple', 'banana', 'cherry'];
?>

<ul>
    <?php foreach ($items as $item): ?>
        <li><?= htmlspecialchars($item) ?></li>
    <?php endforeach; ?>
</ul>

<?php
// ---------------------------------------------------------------------
// 9. Практический пример: фильтрация пользователей.
// ---------------------------------------------------------------------

echo '<h3>9. Практический пример</h3>';

$users = [
    ['name' => 'John', 'newsletter' => true],
    ['name' => 'Jane', 'newsletter' => false],
    ['name' => 'Bob', 'newsletter' => true],
    ['name' => 'Alice', 'newsletter' => false],
];

echo 'Подписаны на рассылку:<br>';

foreach ($users as $user) {
    if (!$user['newsletter']) {
        continue;   // Пропускаем тех, кто не подписан
    }
    echo '- ' . $user['name'] . '<br>';
}

// ---------------------------------------------------------------------
// 10. Поиск элемента с break.
// ---------------------------------------------------------------------

echo '<h3>10. Поиск с break</h3>';

$fruits = ['apple', 'banana', 'orange', 'mango'];
$search = 'orange';
$position = -1;

foreach ($fruits as $index => $fruit) {
    if ($fruit === $search) {
        $position = $index;
        break;   // Нашли — дальше искать не нужно
    }
}

if ($position !== -1) {
    echo "Найдено '$search' на позиции $position.<br>";
} else {
    echo "Элемент '$search' не найден.<br>";
}

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;