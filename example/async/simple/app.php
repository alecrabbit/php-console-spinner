<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Defaults\SpinnerConfig;
use AlecRabbit\Spinner\Core\Pattern\CharPattern\Aesthetic;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Spinner\Helper\MemoryUsage;

require_once __DIR__ . '/../bootstrap.async.php';

echo '--' . PHP_EOL;

$config =
    new SpinnerConfig(
        new WidgetConfig(
            charPattern: new Aesthetic()
        )
    );

$spinner = Facade::createSpinner($config);
$driver = Facade::getDriver();
$loop = Facade::getLoop();

dump($loop);
dump($spinner);
dump($driver);

$loop->repeat(
    1,
    static function () {
        echo MemoryUsage::report() . PHP_EOL;
    }
);
