<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\DriverLinker;
use AlecRabbit\Spinner\Core\DummyDriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;

final readonly class DriverLinkerFactory implements IDriverLinkerFactory
{
    public function __construct(
        protected ILoopProvider $loopProvider,
        protected ILinkerConfig $linkerConfig,
    ) {
    }

    public function create(): IDriverLinker
    {
        if ($this->loopProvider->hasLoop() && $this->isLinkerEnabled()) {
            return
                new DriverLinker(
                    $this->loopProvider->getLoop(),
                );
        }

        return
            new DummyDriverLinker();
    }

    protected function isLinkerEnabled(): bool
    {
        return
            $this->linkerConfig->getLinkerMode() === LinkerMode::ENABLED;
    }
}
