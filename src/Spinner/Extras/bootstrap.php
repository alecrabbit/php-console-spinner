<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Defaults\A\ADefaultsClasses;
use AlecRabbit\Spinner\Core\Factory\DefaultsFactory;
use AlecRabbit\Spinner\Extras\ProceduralFrameRevolverBuilder;
use AlecRabbit\Spinner\Extras\Terminal\SymfonyTerminalProbe;

// @codeCoverageIgnoreStart

DefaultsFactory::addProbe(SymfonyTerminalProbe::class);

ADefaultsClasses::overrideFrameRevolverBuilderClass(ProceduralFrameRevolverBuilder::class);
// @codeCoverageIgnoreEnd