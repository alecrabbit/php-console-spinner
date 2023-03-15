<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Contract;

use AlecRabbit\Spinner\Core\Contract\ISpinner;

interface ILoopSpinnerAttach
{
    public function attach(ISpinner $spinner): void;
}
