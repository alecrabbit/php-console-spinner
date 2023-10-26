<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISignalHandlingSetup;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Settings\Contract\IHandlerCreator;

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
         * @var IHandlerCreator $creator
         */
        foreach ($this->getHandlers() as $signal => $creator) {
            $handler = $creator->createHandler($driver, $this->loop);

            $this->loop->onSignal(
                $signal,
                $handler,
            );
        }
    }

    private function getHandlers(): \Traversable
    {
        return
            $this->loopConfig->getSignalHandlersContainer()
                ->getSignalHandlers()
        ;
    }
}
