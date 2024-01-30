<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * // TODO (2024-01-30 16:24) [Alec Rabbit]: consider extracting to separate package
 *     [799b9a43-72bd-4e89-aa3e-4cf35dec98e8]
 */
interface ISubject
{
    /**
     * Attach an observer to the subject.
     *
     * @throws LogicException
     * @throws InvalidArgument
     */
    public function attach(IObserver $observer): void;

    /**
     * Detach an observer from the subject.
     */
    public function detach(IObserver $observer): void;

    /**
     * // TODO (2024-01-30 16:21) [Alec Rabbit]: consider extend with param:
     *      public function notify(mixed $message = null): void;
     *      // [f1d3c183-1419-4a28-af89-4c7fe9a0948d]
     * Notify all observers about an event.
     */
    public function notify(): void;
}
