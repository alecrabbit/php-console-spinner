<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

/**
 * // TODO (2024-01-30 16:24) [Alec Rabbit]: consider extracting to separate package
 *     [799b9a43-72bd-4e89-aa3e-4cf35dec98e8]
 */
interface IObserver
{
    /**
     * // TODO (2024-01-30 16:21) [Alec Rabbit]: consider extend with param:
     *     public function update(ISubject $subject, mixed $message = null): void;
     *     // [f1d3c183-1419-4a28-af89-4c7fe9a0948d]
     * Receive update from subject.
     */
    public function update(ISubject $subject): void;
}
