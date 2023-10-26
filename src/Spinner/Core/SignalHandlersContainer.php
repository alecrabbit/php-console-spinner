<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

final class SignalHandlersContainer implements ISignalHandlersContainer
{
    public function __construct(protected \Traversable $signalHandlers)
    {
    }

    public function getSignalHandlers(): \Traversable
    {
        return $this->signalHandlers;
    }
}
