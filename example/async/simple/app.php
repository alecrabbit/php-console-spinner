<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;

require_once __DIR__ . '/../bootstrap.async.php';

//// Tune Defaults
//$defaults =
//    \AlecRabbit\Spinner\Factory\DefaultsFactory::create()
//        ->setAttachSignalHandlers(false); // disable signal handling

$spinner = SpinnerFactory::createSpinner();

// that's it :)
