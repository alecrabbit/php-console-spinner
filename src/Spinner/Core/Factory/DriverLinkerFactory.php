<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;
use AlecRabbit\Spinner\Core\Contract\IDisabledDriverDetector;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\DriverLinker;
use AlecRabbit\Spinner\Core\DummyDriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;

final readonly class DriverLinkerFactory implements IDriverLinkerFactory
{
    public function __construct(
        private ILoopProvider $loopProvider,
        private ILinkerConfig $linkerConfig,
        private IDisabledDriverDetector $disabledDriverDetector,
    ) {
    }

    public function create(): IDriverLinker
    {
        if ($this->isEnabled()) {
            return new DriverLinker(
                loop: $this->loopProvider->getLoop(),
            );
        }

        return new DummyDriverLinker();
    }

    private function isEnabled(): bool
    {
        return $this->loopProvider->hasLoop() && $this->isLinkerEnabled() && $this->isDriverEnabled();
    }

    private function isLinkerEnabled(): bool
    {
        return $this->linkerConfig->getLinkerMode() === LinkerMode::ENABLED;
    }

    private function isDriverEnabled(): bool
    {
        return !$this->disabledDriverDetector->isDisabled();
    }
}
