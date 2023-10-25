<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISignalHandlingSetup;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;

final class SignalHandlingSetup implements ISignalHandlingSetup
{
    public function __construct(
        protected ILoop $loop,
        protected ILoopConfig $loopConfig,
    ) {
    }

    public function setup(IDriver $driver): void
    {
        /**
         * @var int $signal
         * @var \Closure $handlerCreator
         */
        foreach ($this->getHandlers() as $signal => $handlerCreator) {
            /** @var \Closure $handler */
            $handler = $handlerCreator($driver, $this->loop);

            $this->loop->onSignal(
                $signal,
                $handler,
            );
        }
    }

    private function getHandlers(): \Traversable
    {
        yield SIGINT => static function (IDriver $driver, ILoop $loop): \Closure {
            return
                static function () use ($driver, $loop): void {
                    $driver->interrupt('Interrupted' . PHP_EOL);
                    $loop->stop();
                };
        };
    }
}
