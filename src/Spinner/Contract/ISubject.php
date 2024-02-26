<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Exception\LogicException;

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
     * Notify all observers about an event.
     */
    public function notify(): void;
}
