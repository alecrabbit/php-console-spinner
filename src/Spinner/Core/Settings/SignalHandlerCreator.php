<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Core\Settings\Contract\IHandlerCreator;
use AlecRabbit\Spinner\Core\Settings\Contract\ISignalHandlerCreator;

final readonly class SignalHandlerCreator implements ISignalHandlerCreator
{
    public function __construct(
        protected int $signal,
        protected IHandlerCreator $handlerCreator,
    ) {
    }

    public function getSignal(): int
    {
        return $this->signal;
    }

    public function getHandlerCreator(): IHandlerCreator
    {
        return $this->handlerCreator;
    }
}
