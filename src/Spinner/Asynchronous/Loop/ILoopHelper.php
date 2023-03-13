<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Loop;

use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\ILoopGetter;
use AlecRabbit\Spinner\Core\Contract\ILoopSignalHandlers;
use AlecRabbit\Spinner\Core\Contract\ILoopSpinnerAttach;
use AlecRabbit\Spinner\Core\Contract\ISpinner;

interface ILoopHelper
{
    public static function attach(ISpinner $spinner): void;

    public static function get(): ILoop|ILoopGetter|ILoopSignalHandlers|ILoopSpinnerAttach;

    public static function autoStart(): void;

    public static function setSignalHandlers(ISpinner $spinner, ?iterable $handlers = null): void;
}