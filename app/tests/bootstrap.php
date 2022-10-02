<?php

use Arslav\Bot\App;

$_ENV['DB_NAME'] = $_ENV['DB_TEST_NAME'];

$container = require_once __DIR__ . '/../bootstrap.php';

return new App($container);
