<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSingletonFactory;

final class LoopSingletonFactory implements ILoopSingletonFactory
{
    private static ?ILoop $loop = null;

    public function __construct(
        protected ILoopProbeFactory $loopProbeFactory,
    ) {
    }

    public function getLoop(): ILoop
    {
        if (self::$loop === null) {
            self::$loop = $this->createLoop();
        }
        return self::$loop;
    }

    private function createLoop(): ILoop
    {
        return $this->getLoopProbe()->createLoop();
    }

    private function getLoopProbe(): ILoopProbe
    {
        return $this->loopProbeFactory->getProbe();
    }
}