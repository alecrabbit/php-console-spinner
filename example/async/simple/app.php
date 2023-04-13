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

$reportInterval = 60;

$loop->repeat(
    $reportInterval,
    static function () {
        $message =
            sprintf(
                '%s %s',
                (new \DateTimeImmutable())->format(DATE_RFC3339_EXTENDED),
                MemoryUsage::report()
            );
        echo $message . PHP_EOL;
    }
);
