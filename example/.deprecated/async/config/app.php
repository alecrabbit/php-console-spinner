<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

/**
 * Example of using custom settings
 */
$defaultsProvider = Facade::getDefaultsProvider();

// # Set custom settings
$defaultsProvider->getDriverSettings()->setFinalMessage(PHP_EOL . '>>> Finished!' . PHP_EOL);

$defaultsProvider->getAuxSettings()->setOptionCursor(
    \AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption::VISIBLE
);

$defaultsProvider->getLoopSettings()->setAttachHandlersOption(
    \AlecRabbit\Spinner\Contract\Option\SignalHandlersOption::DISABLED
);

// # !!! ATTENTION !!! (no spinner output)

// # Spinner will NOT be initialized
//$defaultsProvider->getSpinnerSettings()->setInitializationOption(
//    \AlecRabbit\Spinner\Contract\OptionInitialization::DISABLED
//);

// # Spinner will NOT be attached to loop
//$defaultsProvider->getSpinnerSettings()->setAttachOption(
//    \AlecRabbit\Spinner\Contract\OptionAttach::DISABLED
//);

// # Loop will NOT start automatically
//$defaultsProvider->getLoopSettings()->setAutoStartOption(
//    \AlecRabbit\Spinner\Contract\OptionAutoStart::DISABLED
//);

$spinner = Facade::createSpinner();

// # that's it :)

finalizeSpinner($spinner); // ...and limit run time
