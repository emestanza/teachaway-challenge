<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ .'/../src/app/app.php';
require __DIR__ .'/../src/config/db.php';
require __DIR__ .'/../src/routes/teachaway.php';

// # let Slim starts to run
// without run(), the api routes won't work
$app->run();