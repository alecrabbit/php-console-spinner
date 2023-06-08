<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface ISubject
{
    /**
     * Attach an observer to the subject.
     *
     * @param IObserver $observer
     * @return void
     */
    public function attach(IObserver $observer): void;

    /**
     * Detach an observer from the subject.
     *
     * @param IObserver $observer
     * @return void
     */
    public function detach(IObserver $observer): void;

    /**
     * Notify all observers about an event.
     *
     * @return void
     */
    public function notify(): void;
}
