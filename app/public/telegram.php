<?php

use Arslav\Bot\Telegram\App;

$container = require_once __DIR__ . '/../bootstrap.php';

$app = new App($container);
$app->run();
