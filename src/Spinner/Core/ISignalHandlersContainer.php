<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

interface ISignalHandlersContainer
{
    public function getSignalHandlers(): \Traversable;
}
