<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\Defaults\A\ALoopAwareDefaults;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\ReactLoopProbe;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\RevoltLoopProbe;
use AlecRabbit\Spinner\Core\Factory\StaticDefaultsFactory;


// @codeCoverageIgnoreStart

StaticDefaultsFactory::addProbe(ReactLoopProbe::class);
StaticDefaultsFactory::addProbe(RevoltLoopProbe::class);
StaticDefaultsFactory::setDefaultsClass(ALoopAwareDefaults::class);

// @codeCoverageIgnoreEnd
