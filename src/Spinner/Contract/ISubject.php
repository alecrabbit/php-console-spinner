<?php

declare(strict_types=1);
// 25.04.23
namespace AlecRabbit\Spinner\Contract;

interface ISubject
{
    public function attach(IObserver $observer): void;

    public function detach(IObserver $observer): void;

    public function notify(): void;
}
