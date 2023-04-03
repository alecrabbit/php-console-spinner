<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbeFactory;

final class LoopFactory implements ILoopFactory
{
    protected static ?ILoopAdapter $loop = null;

    public function __construct(
        protected ILoopProbeFactory $loopProbeFactory,
    ) {
    }

    public function getLoop(): ILoopAdapter
    {
        if (null === self::$loop) {
            self::$loop = $this->createLoop();
        }
        return self::$loop;
    }

    protected function createLoop(): ILoopAdapter
    {
        return $this->getLoopProbe()->createLoop();
    }

    protected function getLoopProbe(): ILoopProbe
    {
        return $this->loopProbeFactory->getProbe();
    }

}
