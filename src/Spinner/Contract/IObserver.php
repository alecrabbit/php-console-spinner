<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IObserver
{
    /**
     * Receive update from subject.
     *
     * @param ISubject $subject
     * @return void
     */
    public function update(ISubject $subject): void;
}
