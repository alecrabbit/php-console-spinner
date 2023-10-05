<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Builder\Contract\ISignalHandlersSetupBuilder;
use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Contract\ILegacySignalHandlersSetup;
use AlecRabbit\Spinner\Core\Factory\Contract\ILegacyLoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISignalHandlersSetupFactory;

final class SignalHandlersSetupFactory implements ISignalHandlersSetupFactory
{
    public function __construct(
        protected ILegacySettingsProvider $settingsProvider,
        protected ILegacyLoopFactory $loopFactory,
        protected ISignalHandlersSetupBuilder $signalHandlersSetupBuilder,
    ) {
    }

    public function create(): ILegacySignalHandlersSetup
    {
        return
            $this->signalHandlersSetupBuilder
                ->withLoop($this->loopFactory->getLoop())
                ->withLoopSettings($this->settingsProvider->getLegacyLoopSettings())
                ->withDriverSettings($this->settingsProvider->getLegacyDriverSettings())
                ->build()
        ;
    }
}
