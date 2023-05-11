<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Builder\Contract\ILoopAutoStarterBuilder;
use AlecRabbit\Spinner\Core\Contract\ILoopAutoStarter;
use AlecRabbit\Spinner\Core\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopAutoStarterFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;

final class LoopAutoStarterFactory implements ILoopAutoStarterFactory
{
    public function __construct(
        protected ISettingsProvider $settingsProvider,
        protected ILoopAutoStarterBuilder $autoStarterBuilder,
    ) {
    }

    public function create(): ILoopAutoStarter
    {
        return
            $this->autoStarterBuilder
                ->withSettings($this->settingsProvider->getLoopSettings())
                ->build()
        ;
    }
}
