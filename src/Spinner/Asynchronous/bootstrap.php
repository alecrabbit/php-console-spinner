<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Asynchronous\Defaults\A\ALoopAwareDefaults;
use AlecRabbit\Spinner\Asynchronous\Loop\LoopHelper;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\ReactLoopProbe;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\RevoltLoopProbe;
use AlecRabbit\Spinner\Core\Factory\StaticDefaultsFactory;
use AlecRabbit\Spinner\StaticFacade;

// @codeCoverageIgnoreStart

StaticDefaultsFactory::addProbe(ReactLoopProbe::class);
StaticDefaultsFactory::addProbe(RevoltLoopProbe::class);
StaticDefaultsFactory::setDefaultsClass(ALoopAwareDefaults::class);

StaticFacade::registerLoopHelperClass(LoopHelper::class);

// @codeCoverageIgnoreEnd