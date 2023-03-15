<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

use AlecRabbit\Spinner\Core\Contract\ISpinner;

interface ILoopHelper
{
    public static function attach(ISpinner $spinner): void;

    public static function get(): ILoop|ILoopGetter|ILoopSignalHandlers|ILoopSpinnerAttach;

    public static function autoStart(): void;

    public static function setSignalHandlers(ISpinner $spinner, ?iterable $handlers = null): void;
}