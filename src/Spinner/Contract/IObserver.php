<?php

declare(strict_types=1);
// 25.04.23
namespace AlecRabbit\Spinner\Contract;

interface IObserver
{
    public function update(ISubject $subject): void;
}
