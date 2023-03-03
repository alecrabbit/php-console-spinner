<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Factory;
use AlecRabbit\Spinner\Factory\DefaultsFactory;

require_once __DIR__ . '/../bootstrap.async.php';

//// Tune Defaults
//$defaults =
//    DefaultsFactory::create()
//        ->setAttachSignalHandlers(false); // disable signal handling

$spinner = Factory::createSpinner();

// that's it :)
