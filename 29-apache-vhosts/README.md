# Настройка Apache и виртуальных хостов в XAMPP

> Учебное пособие по PHP 8 · [Видеоурок](https://www.youtube.com/watch?v=ytVPiYILz80&list=PLr3d3QYzkw2xabQRUpcZ_IBk9W50M9pe-&index=30&pp=iAQB)

Этот урок — туториал по базовой настройке Apache и виртуальным хостам в XAMPP на Windows.

## Конфигурация Apache

Основной файл — `httpd.conf` в `C:\xampp\apache\conf\`.

**Ключевые директивы:**

```apache
Listen 80                    # Порт
ServerName localhost         # Имя сервера
DocumentRoot "C:/xampp/htdocs"  # Корень документов
LoadModule rewrite_module modules/mod_rewrite.so  # Модуль перезаписи
Include conf/extra/httpd-vhosts.conf  # Подключение виртуальных хостов
```

**Важно:** строка `Include conf/extra/httpd-vhosts.conf` по умолчанию закомментирована. Её нужно раскомментировать, иначе виртуальные хосты не будут работать.

---

## Виртуальные хосты в XAMPP

### Шаг 1. Включить виртуальные хосты

В `C:\xampp\apache\conf\httpd.conf` найди и раскомментируй:

```apache
Include conf/extra/httpd-vhosts.conf
```

### Шаг 2. Настроить `httpd-vhosts.conf`

Открой `C:\xampp\apache\conf\extra\httpd-vhosts.conf`.

Обязательно добавь `localhost` первым:

```apache
NameVirtualHost *:80

<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs"
    ServerName localhost
    <Directory "C:/xampp/htdocs">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Добавь проект:

```apache
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/php-the-right-way"
    ServerName php-the-right-way.local
    <Directory "C:/xampp/htdocs/php-the-right-way">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
        DirectoryIndex index.php
    </Directory>
    ErrorLog "logs/php-the-right-way-error.log"
    CustomLog "logs/php-the-right-way-access.log" combined
</VirtualHost>
```

Пояснения к директивам:

| Директива | Назначение |
| --- | --- |
| `DocumentRoot` | Путь к файлам сайта |
| `ServerName` | Основной домен |
| `ServerAlias` | Дополнительные домены |
| `AllowOverride All` | Разрешить `.htaccess` |
| `Require all granted` | Apache 2.4: разрешить доступ |
| `DirectoryIndex index.php` | Приоритет `index.php` |
| `ErrorLog` | Путь к логу ошибок |
| `CustomLog` | Путь к логу доступа |

**Важно:** `Require all granted` — синтаксис Apache 2.4. В Apache 2.2 было `Order allow,deny` + `Allow from all`.

### Шаг 3. Настроить файл `hosts`

Открой `C:\Windows\System32\drivers\etc\hosts` от администратора.

Добавь:

```text
127.0.0.1 php-the-right-way.local
127.0.0.1 www.php-the-right-way.local
```

### Шаг 4. Перезапустить Apache

В панели управления XAMPP:

1. Нажми **Stop** у Apache.
2. Нажми **Start** у Apache.

Или проверь конфигурацию:

```cmd
C:\xampp\apache\bin\httpd.exe -t
```

### Шаг 5. Проверить

Открой в браузере:

```text
http://php-the-right-way.local
```

---

## `.htaccess` и `mod_rewrite`

`.htaccess` — распределённый конфигурационный файл. Применяется к каталогу и подкаталогам. Считывается при каждом запросе.

Для работы `.htaccess` нужен `AllowOverride All` в блоке `<Directory>`.

Пример `.htaccess` для единой точки входа:

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]
```

**Когда использовать `.htaccess`:**

- Нет доступа к основному конфигу.
- Нужны настройки на уровне каталога.

**Когда НЕ использовать:**

- Есть доступ к `httpd.conf` — правила лучше разместить там.
- Важна производительность (`.htaccess` замедляет сервер).

---

## Просмотр логов

Панель управления XAMPP → **Logs** → Apache Error Log / Apache Access Log.

---

## Настройка на Linux-сервере (кратко)

```bash
# Создание директории
sudo mkdir -p /var/www/example.com/public_html
sudo chown -R $USER:$USER /var/www/example.com/public_html

# Конфигурация
sudo nano /etc/apache2/sites-available/example.com.conf

# Активация
sudo a2ensite example.com.conf
sudo systemctl restart apache2
```

**Примечание:** эти команды не работают в XAMPP на Windows.

---

## Краткие итоги

- `httpd.conf` — основной конфиг Apache.
- `httpd-vhosts.conf` — виртуальные хосты в XAMPP.
- `Include` — подключение доп. конфигов.
- `AllowOverride All` — для `.htaccess`.
- `Require all granted` — Apache 2.4.
- `hosts` — привязка доменов к `127.0.0.1`.
- `DirectoryIndex index.php` — приоритет `index.php`.

---

## Практика

Создай файл `index.php` и выполни следующие задачи:

1. Создай виртуальный хост `myproject.local` в XAMPP, указывающий на `C:/xampp/htdocs/myproject`.
2. Добавь запись в файл `hosts` для нового домена.
3. Создай `.htaccess` с правилом перезаписи для единой точки входа.
4. В `index.php` выведи `phpinfo()` и найди `Loaded Configuration File`.
5. Настрой `DirectoryIndex` так, чтобы `index.php` имел приоритет над `index.html`.
6. Создай второй виртуальный хост `api.local` на порту 80.
7. Настрой `ErrorLog` и `CustomLog` для каждого виртуального хоста отдельно.
8. Проверь конфигурацию Apache командой `httpd.exe -t` и исправь ошибки, если есть.