<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IFinalizable;
use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\IInitializable;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\IRenderable;
use AlecRabbit\Spinner\Contract\ISubject;
use Closure;

interface IDriver extends IObserver,
                          ISubject,
                          IRenderable,
                          IHasInterval,
                          IInitializable,
                          IFinalizable
{
    /**
     * Adds spinner to the driver.
     */
    public function add(ISpinner $spinner): void;

    /**
     * Checks if spinner is in the driver.
     */
    public function has(ISpinner $spinner): bool;

    /**
     * Removes spinner from the driver. Fails silently if spinner is not in the driver.
     */
    public function remove(ISpinner $spinner): void;

    public function interrupt(?string $interruptMessage = null): void;

    /**
     * Wraps a user callback with erase and render methods calls. Returns wrapped callback.
     *
     * @return Closure(): void
     */
    public function wrap(Closure $callback): Closure;
}
