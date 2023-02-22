<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Core\Loop\Contract;

use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Exception\RuntimeException;

interface ILoop
{
    public function attach(ISpinner $spinner): void;

    public function setSignalHandlers(iterable $handlers): void;

    /**
     * @throws RuntimeException
     */
    public function createHandlers(ISpinner $spinner): iterable;

    public function autoStart(): void;
}
