<?php

declare(strict_types=1);
// 17.02.23

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Exception\RuntimeException;

// TODO choose better name
interface ILoopSignalHandlers
{
    public function setSignalHandlers(iterable $handlers): void;

    /**
     * @throws RuntimeException
     */
    public function createSignalHandlers(ISpinner $spinner): iterable;
}
