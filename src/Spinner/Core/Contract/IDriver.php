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
    /**
     * Adds spinner to the driver.
     *
     * @param ISpinner $spinner
     * @return void
     */
    public function add(ISpinner $spinner): void;

    /**
     * Checks if spinner is in the driver.
     *
     * @param ISpinner $spinner
     * @return bool
     */
    public function has(ISpinner $spinner): bool;

    /**
     * Removes spinner from the driver. Fails silently if spinner is not in the driver.
     *
     * @param ISpinner $spinner
     * @return void
     */
    public function remove(ISpinner $spinner): void;

    /**
     * Initializes driver. Hides cursor(if enabled).
     *
     * @return void
     */
    public function initialize(): void;

    /**
     * Interrupts driver. Erases spinner(s) and outputs interrupt message. Shows cursor(if enabled).
     *
     * @param string|null $interruptMessage
     * @return void
     */
    public function interrupt(?string $interruptMessage = null): void;

    /**
     * Finalizes driver. Erases spinner(s) and outputs final message. Shows cursor(if enabled).
     *
     * @param string|null $finalMessage
     * @return void
     */
    public function finalize(?string $finalMessage = null): void;

    /**
     * Wraps a user callback with erase and render methods calls. Returns wrapped callback.
     *
     * @param Closure $callback
     * @return Closure(): void
     */
    public function wrap(Closure $callback): Closure;
}
