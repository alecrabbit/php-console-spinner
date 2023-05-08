<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$settingsProvider = Facade::getSettingsProvider();
$settingsProvider
    ->getTerminalSettings()
    ->setOptionStyleMode(
        \AlecRabbit\Spinner\Contract\Option\OptionStyleMode::NONE
    )
;
//$settingsProvider
//    ->getLoopSettings()
//    ->setOptionAutoStart(
//        \AlecRabbit\Spinner\Contract\Option\OptionAutoStart::DISABLED
//    )
//;

$config =
    new WidgetConfig();

$spinner = Facade::createSpinner($config);
