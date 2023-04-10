<?php

declare(strict_types=1);
// 17.02.23

namespace AlecRabbit\Spinner\Core\Contract;

interface ILegacySpinnerAttacher
{
    public function attach(ILegacySpinner $spinner): void;
}
