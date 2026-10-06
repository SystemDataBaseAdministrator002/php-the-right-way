# PHP The Right Way — учебный курс

Личный конспект и практика по курсу
[«Learn PHP The Right Way»](https://www.youtube.com/playlist?list=PLr3d3QYzkw2xabQRUpcZ_IBk9W50M9pe-)
от **Program With Gio**.

Курс состоит из 139 видео. В этом репозитории собрана пока что только **первая (базовая) часть** — 30 уроков.

## Содержание

### Уроки 01–30

Базовый курс PHP 8: от установки до работы с файловой системой.

| # | Тема | Папка |
|---|---|---|
| 01 | Установка PHP и веб-серверы | [`01-php-setup`](./01-php-setup/) |
| 02 | Базовый синтаксис | [`02-basic-syntax`](./02-basic-syntax/) |
| 03 | Константы и переменные переменные | [`03-constants-variables`](./03-constants-variables/) |
| 04 | Типы данных и приведение типов | [`04-data-types-casting`](./04-data-types-casting/) |
| 05 | Логический тип (Boolean) | [`05-boolean`](./05-boolean/) |
| 06 | Целые числа (Integer) | [`06-integer`](./06-integer/) |
| 07 | Числа с плавающей запятой (Float) | [`07-float`](./07-float/) |
| 08 | Строки: Heredoc и Nowdoc | [`08-string-heredoc-nowdoc`](./08-string-heredoc-nowdoc/) |
| 09 | Тип данных Null | [`09-null`](./09-null/) |
| 10 | Массивы | [`10-array`](./10-array/) |
| 11 | Выражения | [`11-expressions`](./11-expressions/) |
| 12 | Операторы, часть 1 | [`12-operators-p1`](./12-operators-p1/) |
| 13 | Операторы, часть 2 | [`13-operators-p2`](./13-operators-p2/) |
| 14 | Приоритет и ассоциативность операторов | [`14-operator-precedence`](./14-operator-precedence/) |
| 15 | Условные операторы: if, else, elseif | [`15-control-structures-if-else`](./15-control-structures-if-else/) |
| 16 | Циклы: while, do-while, for, foreach. break и continue | [`16-loops-break-continue`](./16-loops-break-continue/) |
| 17 | Оператор switch | [`17-switch`](./17-switch/) |
| 18 | Выражение match | [`18-match`](./18-match/) |
| 19 | Оператор return и директива declare | [`19-return-declare-tickable`](./19-return-declare-tickable/) |
| 20 | Включение файлов: include, require, _once | [`20-include-require`](./20-include-require/) |
| 21 | Создание функций | [`21-functions`](./21-functions/) |
| 22 | Параметры функций: именованные аргументы, variadic, splat | [`22-function-params-variadic`](./22-function-params-variadic/) |
| 23 | Области видимости и статические переменные | [`23-variable-scope-static`](./23-variable-scope-static/) |
| 24 | Анонимные функции, замыкания, стрелочные функции | [`24-closures-arrow-functions`](./24-closures-arrow-functions/) |
| 25 | Работа с датами и часовыми поясами | [`25-dates-timezones`](./25-dates-timezones/) |
| 26 | Функции для работы с массивами | [`26-arrays-functions`](./26-arrays-functions/) |
| 27 | Конфигурация PHP: php.ini | [`27-php-ini`](./27-php-ini/) |
| 28 | Обработка ошибок | [`28-error-handling`](./28-error-handling/) |
| 29 | Настройка Apache и виртуальных хостов | [`29-apache-vhosts`](./29-apache-vhosts/) |
| 30 | Работа с файловой системой | [`30-filesystem`](./30-filesystem/) |

> Каждый урок содержит `README.md` (конспект + теория) и `index.php` (практический код).

### Алгоритмические задачи

Коллекция задач для закрепления базовых конструкций PHP: условия, циклы, массивы, функции.

Полный список — в папке [`php-algorithms`](https://github.com/SystemDataBaseAdministrator002/php-algorithms) (отдельный репозиторий).

## Требования

- PHP 8.2+
- Apache (XAMPP) или встроенный сервер PHP
- MySQL (для будущих уроков)

## Запуск

1. Клонируй репозиторий в `htdocs`:

   ```bash
   cd C:\xampp\htdocs
   git clone https://github.com/SystemDataBaseAdministrator002/php-the-right-way.git
   ```

2. Открой в браузере любой урок:

    ```text
    http://localhost/php-the-right-way/02-basic-syntax/
    ```

3. Структура репозитория:

    ```text
    php-the-right-way/
    ├── README.md
    ├── .gitignore
    ├── 01-php-setup/
    │   ├── README.md
    │   ├── index.php
    │   └── info.php
    ├── 02-basic-syntax/
    │   ├── README.md
    │   └── index.php
    ├── 03-constants-variables/
    │   ├── README.md
    │   └── index.php
    ├── 04-data-types-casting/
    │   ├── README.md
    │   └── index.php
    ├── 05-boolean/
    │   ├── README.md
    │   └── index.php
    ├── 06-integer/
    │   ├── README.md
    │   └── index.php
    ├── 07-float/
    │   ├── README.md
    │   └── index.php
    ├── 08-string-heredoc-nowdoc/
    │   ├── README.md
    │   └── index.php
    ├── 09-null/
    │   ├── README.md
    │   └── index.php
    ├── 10-array/
    │   ├── README.md
    │   └── index.php
    ├── 11-expressions/
    │   ├── README.md
    │   └── index.php
    ├── 12-operators-p1/
    │   ├── README.md
    │   └── index.php
    ├── 13-operators-p2/
    │   ├── README.md
    │   └── index.php
    ├── 14-operator-precedence/
    │   ├── README.md
    │   └── index.php
    ├── 15-control-structures-if-else/
    │   ├── README.md
    │   └── index.php
    ├── 16-loops-break-continue/
    │   ├── README.md
    │   └── index.php
    ├── 17-switch/
    │   ├── README.md
    │   └── index.php
    ├── 18-match/
    │   ├── README.md
    │   └── index.php
    ├── 19-return-declare-tickable/
    │   ├── README.md
    │   └── index.php
    ├── 20-include-require/
    │   ├── README.md
    │   └── index.php
    ├── 21-functions/
    │   ├── README.md
    │   └── index.php
    ├── 22-function-params-variadic/
    │   ├── README.md
    │   └── index.php
    ├── 23-variable-scope-static/
    │   ├── README.md
    │   └── index.php
    ├── 24-closures-arrow-functions/
    │   ├── README.md
    │   └── index.php
    ├── 25-dates-timezones/
    │   ├── README.md
    │   └── index.php
    ├── 26-arrays-functions/
    │   ├── README.md
    │   └── index.php
    ├── 27-php-ini/
    │   ├── README.md
    │   └── index.php
    ├── 28-error-handling/
    │   ├── README.md
    │   └── index.php
    ├── 29-apache-vhosts/
    │   ├── README.md
    │   └── notes.md
    └── 30-filesystem/
        ├── README.md
        └── index.php
    ``` 

4. Прогресс:

- [x] Уроки 01–30 (базовый курс);
- [ ] Уроки 31+ (ООП);
- [ ] Composer, PSR-4, автозагрузка;
- [ ] Тестирование (PHPUnit);
- [ ] DI-контейнер;
- [ ] Doctrine ORM;
- [ ] Slim Framework.

## Лицензия

Код — свободный, можно использовать как хочешь. Конспекты — мои личные заметки, могут содержать ошибки.

## Ссылки

- [Курс на YouTube](https://www.youtube.com/playlist?list=PLr3d3QYzkw2xabQRUpcZ_IBk9W50M9pe-)
- [Канал Program With Gio](https://www.youtube.com/@ProgramWithGio)
- [Официальная документация PHP](https://www.php.net/manual/ru/)