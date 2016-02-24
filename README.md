# KDB client
PHP client for [KDB (Koraduba)](https://github.com/iborodikhin/kdb) file storage

## Installation
```composer require iborodikhin/kdb-client```

## Basic usage
```php
require "vendor/autoload.php";

// Create client instance
$client = new \Kdb\Client([
    'host' => '127.0.0.1',
    'port' => 1337,
]);

// Upload a file.
$isSaved = $client->save(__FILE__, "samples/" . basename(__FILE__));

// Check if file exists.
$isFile = $client->exists("samples/" . basename(__FILE__));

// \Kdb\File instance.
$file = $client->get("samples/" . basename(__FILE__));

// Remove a file.
$isDeleted = $client->remove("samples/" . basename(__FILE__));
```