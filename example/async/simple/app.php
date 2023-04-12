<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

echo '--' . PHP_EOL;

$spinner = Facade::createSpinner();
$driver = Facade::getDriver();
$loop = Facade::getLoop();

//dump($driver);
//dump($loop);
dump($spinner);
