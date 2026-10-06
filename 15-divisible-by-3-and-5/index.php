<?php

declare(strict_types=1);

// Проверка делимости на 3 и на 5 одновременно

$n = 15;
// Если число делится и на 3, и на 5 — выведи "Делится на 3 и на 5",
// Если только на 3 — "Делится на 3",
// Если только на 5 — "Делится на 5",
// Иначе просто число.

function checkDivisibility(int $n): string { 
    if ($n % 3 === 0 && $n % 5 === 0) {
        return "Делится на 3 и на 5";
    } elseif ($n % 3 === 0) {
        return "Делится на 3";
    } elseif ($n % 5 === 0) {
        return "Делится на 5";
    } else {
        return (string) $n;
    }
}

echo checkDivisibility($n);

echo '<hr>';
echo 'Версия PHP: ' . PHP_VERSION;