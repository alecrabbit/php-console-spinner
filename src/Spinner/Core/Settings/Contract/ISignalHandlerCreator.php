<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

interface ISignalHandlerCreator
{
    public function getSignal(): int;

    public function getHandlerCreator(): IHandlerCreator;
}
