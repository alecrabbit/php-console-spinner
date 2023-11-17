<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IObserver
{
    /**
     * Receive update from subject.
     */
    public function update(ISubject $subject): void;
}
