<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Builder\Contract\ILoopAutoStarterBuilder;
use AlecRabbit\Spinner\Core\Contract\ILoopAutoStarter;
use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopAutoStarterFactory;

final class LoopAutoStarterFactory implements ILoopAutoStarterFactory
{
    public function __construct(
        protected ILegacySettingsProvider $settingsProvider,
        protected ILoopAutoStarterBuilder $autoStarterBuilder,
    ) {
    }

    public function create(): ILoopAutoStarter
    {
        return
            $this->autoStarterBuilder
                ->withSettings($this->settingsProvider->getLegacyLoopSettings())
                ->build()
        ;
    }
}
