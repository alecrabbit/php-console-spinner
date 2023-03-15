<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Core\Contract;

interface ILoopSpinnerAttach
{
    public function attach(ISpinner $spinner): void;
}