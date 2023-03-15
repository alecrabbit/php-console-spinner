<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Contract;

interface ILoopSpinnerAttach
{
    public function attach(ISpinner $spinner): void;
}
