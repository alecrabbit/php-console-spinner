<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\Loop\Loop;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\ReactLoopProbe;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\RevoltLoopProbe;
use AlecRabbit\Spinner\Core\Factory\DefaultsFactory;
use AlecRabbit\Spinner\Factory;

DefaultsFactory::addProbe(ReactLoopProbe::class);
DefaultsFactory::addProbe(RevoltLoopProbe::class);

Factory::registerLoopClass(Loop::class);
