<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Legacy;

use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Contract\ILegacySignalHandlersSetup;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;

/**
 * @deprecated Will be removed
 */
final class LegacySignalHandlersSetupFactory implements ILegacySignalHandlersSetupFactory
{
    public function __construct(
        protected ILegacySettingsProvider $settingsProvider,
        protected ILoopFactory $loopFactory,
        protected ILegacySignalHandlersSetupBuilder $signalHandlersSetupBuilder,
    ) {
    }

    public function create(): ILegacySignalHandlersSetup
    {
        return
            $this->signalHandlersSetupBuilder
                ->withLoop($this->loopFactory->create())
                ->withLoopSettings($this->settingsProvider->getLegacyLoopSettings())
                ->withDriverSettings($this->settingsProvider->getLegacyDriverSettings())
                ->build()
        ;
    }
}
