<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbeFactory;

final class LoopFactory implements ILoopFactory
{
    protected static ?ILoop $loop = null;

    public function __construct(
        protected ILoopProbeFactory $loopProbeFactory,
        protected ILoopSetupBuilder $loopSetupBuilder,
    ) {
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

    public function getLoopSetup(ILoopConfig $loopConfig): ILoopSetup
    {
        return $this->loopSetupBuilder
            ->withLoop($this->getLoop())
            ->withConfig($loopConfig)
            ->build();
    }
}
