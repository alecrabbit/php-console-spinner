<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

dump('-----');

$spinner = Facade::createSpinner();

dump($spinner);
