<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Defaults\A\ADefaultsClasses;
use AlecRabbit\Spinner\Core\Factory\StaticDefaultsFactory;
use AlecRabbit\Spinner\Extras\ProceduralFrameRevolverBuilder;
use AlecRabbit\Spinner\Extras\Terminal\SymfonyTerminalProbe;

// @codeCoverageIgnoreStart

StaticDefaultsFactory::addProbe(SymfonyTerminalProbe::class);

ADefaultsClasses::overrideFrameRevolverBuilderClass(ProceduralFrameRevolverBuilder::class);
// @codeCoverageIgnoreEnd
