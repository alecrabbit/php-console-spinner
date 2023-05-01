<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Builder\Contract\ILoopSetupBuilder;
use AlecRabbit\Spinner\Core\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSetupFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSingletonFactory;

final class LoopSetupFactory implements ILoopSetupFactory
{
    public function __construct(
        protected ISettingsProvider $defaultsProvider,
        protected ILoopSingletonFactory $loopFactory,
        protected ILoopSetupBuilder $loopSetupBuilder,
    ) {
    }

    public function create(): ILoopSetup
    {
        return $this->loopSetupBuilder
            ->withLoop($this->loopFactory->getLoop())
            ->withSettings($this->defaultsProvider->getLoopSettings())
            ->build()
        ;
    }
}
