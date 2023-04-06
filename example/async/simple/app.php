<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$spinner = Facade::createSpinner();

// # that's it :)

finalizeSpinner($spinner); // ...and limit run time
