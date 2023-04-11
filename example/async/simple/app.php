<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$driver = Facade::getDriver();

dump($driver);
