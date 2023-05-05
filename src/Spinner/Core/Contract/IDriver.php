<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\IRenderable;
use AlecRabbit\Spinner\Contract\ISubject;
use Closure;

interface IDriver extends IObserver,
                          ISubject,
                          IRenderable,
                          IHasInterval
{
    public function add(ISpinner $spinner): void;

    public function remove(ISpinner $spinner): void;

    public function initialize(): void;

    public function interrupt(?string $interruptMessage = null): void;

    public function finalize(?string $finalMessage = null): void;

    public function wrap(Closure $callback): Closure;
}
