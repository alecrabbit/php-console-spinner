<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

final class SignalHandlersContainer implements ISignalHandlersContainer
{
    public function __construct(
        protected \Traversable $signalHandlers = new \ArrayObject(), // FIXME (2023-10-25 16:40) [Alec Rabbit]: remove default value
    ) {
    }

    public function getSignalHandlers(): \Traversable
    {
        return $this->signalHandlers;
    }
}
