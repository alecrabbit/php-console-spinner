<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$config =
    Facade::getConfigBuilder()
        ->build()
;

$spinner = Facade::createSpinner($config);

// that's it :)

dump($spinner, $config);
