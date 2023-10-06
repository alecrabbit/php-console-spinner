<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Builder\Contract\ILegacyLoopAutoStarterBuilder;
use AlecRabbit\Spinner\Core\Contract\ILegacyLoopAutoStarter;
use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\ILegacyLoopAutoStarterFactory;

/**
 * @deprecated
 */
final class LegacyLoopAutoStarterFactory implements ILegacyLoopAutoStarterFactory
{
    public function __construct(
        protected ILegacySettingsProvider $settingsProvider,
        protected ILegacyLoopAutoStarterBuilder $autoStarterBuilder,
    ) {
    }

    public function create(): ILegacyLoopAutoStarter
    {
        return
            $this->autoStarterBuilder
                ->withSettings($this->settingsProvider->getLegacyLoopSettings())
                ->build()
        ;
    }
}
