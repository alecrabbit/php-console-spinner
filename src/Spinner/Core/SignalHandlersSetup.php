<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISignalHandlersSetup;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyLoopSettings;
use Closure;
use Traversable;

final class SignalHandlersSetup implements ISignalHandlersSetup
{
    public function __construct(
        protected ILoop $loop,
        protected ILegacyLoopSettings $loopSettings,
        protected ILegacyDriverSettings $driverSettings,
    ) {
    }

    public function setup(IDriver $driver): void
    {
        if ($this->isSetupEnabled()) {
            foreach ($this->signalHandlers($driver) as $signal => $handler) {
                $this->loop->onSignal($signal, $handler);
            }
        }
    }

    protected function isSetupEnabled(): bool
    {
        return
            $this->loopSettings->isLoopAvailable()
            && $this->loopSettings->isSignalProcessingAvailable()
            && $this->loopSettings->isAttachHandlersEnabled();
    }

    /**
     * @param IDriver $driver
     * @return Traversable<int, Closure>
     */
    private function signalHandlers(IDriver $driver): Traversable
    {
        yield from [
            // @codeCoverageIgnoreStart
            SIGINT => function () use ($driver): void {
                $driver->interrupt($this->driverSettings->getInterruptMessage());
                $this->loop->stop();
            },
            // @codeCoverageIgnoreEnd
        ];
    }

}
