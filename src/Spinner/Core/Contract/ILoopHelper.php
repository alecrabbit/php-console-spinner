<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface ILoopHelper
{
    public static function attach(ISpinner $spinner): void;

    public static function get(): ILoopAdapter;

    public static function autoStart(): void;

    public static function setSignalHandlers(ISpinner $spinner, ?iterable $handlers = null): void;
}
