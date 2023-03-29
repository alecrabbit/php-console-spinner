<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\IInterval;

interface ISpinnerConfig
{
    public function isEnabledInitialization(): bool;

    public function getInterval(): IInterval;
}
