<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Spinner\Helper\MemoryUsage;

require_once __DIR__ . '/../bootstrap.async.php';

$driver = Facade::getDriver();
$wrapped =
    $driver->wrap(
        static function (string $message) {
            echo $message . PHP_EOL;
        }
    );

$reportInterval = 60;

$memoryReport = static function () use ($wrapped): void {
    static $m = new MemoryUsage();

    $wrapped(
        sprintf(
            '%s %s',
            (new DateTimeImmutable())->format(DATE_RFC3339_EXTENDED),
            $m->report(),
        )
    );
};

echo '--' . PHP_EOL;
$memoryReport();


$settingsProvider = Facade::getSettingsProvider();
$settingsProvider
    ->getTerminalSettings()
    ->setOptionStyleMode(
        \AlecRabbit\Spinner\Contract\Option\OptionStyleMode::ANSI8
    )
;
//$settingsProvider
//    ->getLoopSettings()
//    ->setOptionAutoStart(
//        \AlecRabbit\Spinner\Contract\Option\OptionAutoStart::DISABLED
//    )
//;

//dump($settingsProvider);

$config =
    new WidgetConfig(
        stylePattern: new \AlecRabbit\Spinner\Core\Pattern\StylePattern\Rainbow(),
//        charPattern: new \AlecRabbit\Spinner\Core\Pattern\CharPattern\SwirlingDots()
);

$spinner = Facade::createSpinner($config);

$loop = Facade::getLoop();

//dump($loop);
//dump($driver);
//dump($spinner);

$loop->repeat(
    $reportInterval,
    $memoryReport
);
