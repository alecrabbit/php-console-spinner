<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Config\SpinnerConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Pattern\CharPattern\SwirlingDots;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Spinner\Helper\MemoryUsage;

require_once __DIR__ . '/../bootstrap.async.php';

$reportInterval = 60;
$m = new MemoryUsage();

echo '--' . PHP_EOL;
echo $m->report() . PHP_EOL;

$defaultsProvider = Facade::getDefaultsProvider();
$defaultsProvider
    ->getTerminalSettings()
    ->setOptionStyleMode(
        \AlecRabbit\Spinner\Contract\Option\OptionStyleMode::NONE
    )
;
//$defaultsProvider
//    ->getLoopSettings()
//    ->setOptionAutoStart(
//        \AlecRabbit\Spinner\Contract\Option\OptionAutoStart::DISABLED
//    )
//;

//dump($defaultsProvider);

$config =
    new SpinnerConfig(
        new WidgetConfig(
            charPattern: new SwirlingDots()
        )
    );


$spinner = Facade::createSpinner($config);
$driver = Facade::getDriver();
$loop = Facade::getLoop();

//dump($loop);
//dump($spinner);
//dump($driver);

$loop->repeat(
    $reportInterval,
    static function () use ($m) {
        $message =
            sprintf(
                '%s %s',
                (new DateTimeImmutable())->format(DATE_RFC3339_EXTENDED),
                $m->report(),
            );
        echo $message . PHP_EOL;
    }
);
