<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\Probe\ILoopProbe;
use AlecRabbit\Spinner\Core\Factory\Contract\ILegacyLoopAutoStarterFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILegacyLoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILegacyLoopProbeFactory;

/**
 * @deprecated
 */
final class LegacyLoopFactory implements ILegacyLoopFactory
{
    private static ?ILoop $loop = null;

    public function __construct(
        protected ILegacyLoopProbeFactory $loopProbeFactory,
        protected ILegacyLoopAutoStarterFactory $loopAutoStarterFactory,
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
