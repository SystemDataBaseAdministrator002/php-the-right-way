<?php 

declare(strict_types= 1);

// Перевернуть массив

$arr = [1, 2, 3, 4, 5];
// Сделай так, чтобы он стал [5, 4, 3, 2, 1]

function reverseArray(array $arr): array{
    $result = $arr;
    $left = 0;
    $right = count($result) - 1;

    while ($left < $right) {
        $temp = $result[$left];
        $result[$left] = $result[$right];
        $result[$right] = $temp;

        $left++;
        $right--;
    }

    return $result;
}

print_r(reverseArray($arr));

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;