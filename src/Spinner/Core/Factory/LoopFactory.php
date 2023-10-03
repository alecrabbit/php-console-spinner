<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\Probe\ILoopProbe;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopAutoStarterFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProbeFactory;

final class LoopFactory implements ILoopFactory
{
    private static ?ILoop $loop = null;

    public function __construct(
        protected ILoopProbeFactory $loopProbeFactory,
        protected ILoopAutoStarterFactory $loopAutoStarterFactory,
    ) {
    }

    public function getLoop(): ILoop
    {
        if (self::$loop === null) {
            self::$loop = $this->createLoop();

            $this->setupLoop(self::$loop);
        }
        return self::$loop;
    }

    private function createLoop(): ILoop
    {
        return
            $this->createProbe()->createLoop();
    }

    private function createProbe(): ILoopProbe
    {
        return
            $this->loopProbeFactory->createProbe();
    }

    private function setupLoop(ILoop $loop): void
    {
        $this->loopAutoStarterFactory
            ->create()
            ->setup($loop)
        ;
    }
}
