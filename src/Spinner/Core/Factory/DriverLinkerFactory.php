<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopProvider;
use AlecRabbit\Spinner\Core\DriverLinker;
use AlecRabbit\Spinner\Core\DummyDriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;

final class DriverLinkerFactory implements IDriverLinkerFactory
{
    public function __construct(
        protected ILoopProvider $loopProvider,
        protected IDriverConfig $driverConfig,
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
            $this->driverConfig->getLinkerMode() === LinkerMode::ENABLED;
    }
}
