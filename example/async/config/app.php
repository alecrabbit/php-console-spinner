<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Config\Legacy\LegacyWidgetConfig;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$settingsProvider = Facade::getLegacySettingsProvider();
$settingsProvider
    ->getLegacyTerminalSettings()
    ->setOptionStyleMode(
        \AlecRabbit\Spinner\Contract\Option\StylingMethodOption::NONE
    )
;
$settingsProvider
    ->getLegacyDriverSettings()
    ->setInterruptMessage(' Interrupted!' . PHP_EOL)
;
//$settingsProvider
//    ->getLoopSettings()
//    ->setOptionAutoStart(
//        \AlecRabbit\Spinner\Contract\Option\OptionAutoStart::DISABLED
//    )
//;

$config =
    new LegacyWidgetConfig();

$spinner = Facade::legacyCreateSpinner($config);
