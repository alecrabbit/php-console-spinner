<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface ISubject
{
    /**
     * Attach an observer to the subject.
     */
    public function attach(IObserver $observer): void;

    /**
     * Detach an observer from the subject.
     */
    public function detach(IObserver $observer): void;

    /**
     * Notify all observers about an event.
     */
    public function notify(): void;
}
