<?php

use Arslav\Bot\Vk\App;

$container = require_once __DIR__ . '/../bootstrap.php';

$app = new App($container);
$app->run();
