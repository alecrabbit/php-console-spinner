<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Legacy;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ILegacySignalHandlersSetup;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyLoopSettings;
use Closure;
use Traversable;

/**
 * @deprecated
 */
final class LegacySignalHandlersSetup implements ILegacySignalHandlersSetup
{
    public function __construct(
        protected ILoop $loop,
        protected ILegacyLoopSettings $loopSettings,
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
                $driver->interrupt();
                $this->loop->stop();
            },
            // @codeCoverageIgnoreEnd
        ];
    }

}
