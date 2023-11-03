<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ISignalHandlersContainer;
use AlecRabbit\Spinner\Core\Settings\Contract\IHandlerCreator;
use Traversable;

final class SignalHandlersContainer implements ISignalHandlersContainer
{
    /**
     * @param Traversable<int, IHandlerCreator> $signalHandlers
     */
    public function __construct(protected Traversable $signalHandlers)
    {
    }

    /** @inheritDoc */
    public function getHandlerCreators(): Traversable
    {
        return $this->signalHandlers;
    }
}
