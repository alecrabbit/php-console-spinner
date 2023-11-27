<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\IDriverModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\DriverLinker;
use AlecRabbit\Spinner\Core\DummyDriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;
use AlecRabbit\Spinner\Core\Feature\Resolver\Contract\ILinkerResolver;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;

final readonly class DriverLinkerFactory implements IDriverLinkerFactory
{
    public function __construct(
        private ILoopProvider $loopProvider,
        private ILinkerResolver $linkerResolver,
    ) {
    }

    public function create(): IDriverLinker
    {
        if ($this->isLinkerEnabled()) {
            return new DriverLinker(
                loop: $this->loopProvider->getLoop(),
            );
        }

        return new DummyDriverLinker();
    }

    private function isLinkerEnabled(): bool
    {
        return $this->loopProvider->hasLoop() && $this->linkerResolver->isEnabled();
    }
}
