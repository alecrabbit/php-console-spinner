<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\Defaults\A\ALoopAwareDefaults;
use AlecRabbit\Spinner\Asynchronous\Loop\LoopHelper;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\ReactLoopProbe;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\RevoltLoopProbe;
use AlecRabbit\Spinner\Core\Factory\DefaultsFactory;
use AlecRabbit\Spinner\Facade;

// @codeCoverageIgnoreStart

DefaultsFactory::addProbe(ReactLoopProbe::class);
DefaultsFactory::addProbe(RevoltLoopProbe::class);
DefaultsFactory::setDefaultsClass(ALoopAwareDefaults::class);

Facade::registerLoopHelperClass(LoopHelper::class);

// @codeCoverageIgnoreEnd