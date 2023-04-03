<?php

declare(strict_types=1);
// 17.02.23

namespace AlecRabbit\Spinner\Core\Loop\Contract;

use AlecRabbit\Spinner\Core\Contract\ISpinner;
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
