<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Mode\SignalHandlingMode;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Contract\ISignalHandlingSetup;
use AlecRabbit\Spinner\Core\DummySignalHandlingSetup;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;
use AlecRabbit\Spinner\Core\SignalHandlingSetup;

final class SignalHandlingSetupFactory implements Contract\ISignalHandlingSetupFactory
{
    public function __construct(
        protected ILoopProvider $loopProvider,
        protected ILoopConfig $loopConfig,
    ) {
    }

    public function create(): ISignalHandlingSetup
    {
        if ($this->loopProvider->hasLoop() && $this->isSignalHandlingEnabled()) {
            return new SignalHandlingSetup(
                $this->loopProvider->getLoop(),
                $this->loopConfig,
            );
        }

        return
            new DummySignalHandlingSetup();
    }

    private function isSignalHandlingEnabled(): bool
    {
        return
            $this->loopConfig->getSignalHandlingMode() === SignalHandlingMode::ENABLED;
    }
}
