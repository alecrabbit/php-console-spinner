<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Contract\ILoopSetupBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;

final class LoopFactory implements ILoopFactory
{
    protected static ?ILoop $loop = null;

    public function __construct(
        protected IDefaultsProvider $defaultsProvider,
        protected ILoopProbeFactory $loopProbeFactory,
        protected ILoopSetupBuilder $loopSetupBuilder,
    ) {
    }

    public function getLoopSetup(): ILoopSetup
    {
        return
            $this->loopSetupBuilder
                ->withLoop($this->getLoop())
                ->withSettings($this->defaultsProvider->getLoopSettings())
                ->build()
        ;
    }

    public function getLoop(): ILoop
    {
        if (null === self::$loop) {
            self::$loop = $this->createLoop();
        }
        return self::$loop;
    }

    protected function createLoop(): ILoop
    {
        return $this->getLoopProbe()->createLoop();
    }

    protected function getLoopProbe(): ILoopProbe
    {
        return $this->loopProbeFactory->getProbe();
    }
}
