<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Builder\Contract\ISignalHandlersSetupBuilder;
use AlecRabbit\Spinner\Core\Contract\ISignalHandlersSetup;
use AlecRabbit\Spinner\Core\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISignalHandlersSetupFactory;

final class SignalHandlersSetupFactory implements ISignalHandlersSetupFactory
{
    public function __construct(
        protected ISettingsProvider $settingsProvider,
        protected ILoopFactory $loopFactory,
        protected ISignalHandlersSetupBuilder $loopSetupBuilder,
    ) {
    }

    public function create(): ISignalHandlersSetup
    {
        return
            $this->loopSetupBuilder
                ->withLoop($this->loopFactory->getLoop())
                ->withSettings($this->settingsProvider->getLoopSettings())
                ->build()
        ;
    }
}
