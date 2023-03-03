<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Factory;

require_once __DIR__ . '/../bootstrap.async.php';

//// Tune Defaults
//$defaults =
//    \AlecRabbit\Spinner\Factory\DefaultsFactory::create()
//        ->setAttachSignalHandlers(false); // disable signal handling

$spinner = Factory::createSpinner();

// that's it :)
