<?php

use Arslav\Bot\App;

$container = require __DIR__ . '/../bootstrap.php';

$app = new App($container);
$app->run();
