<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config\Contract;

interface ISpinnerConfig
{
    public function isEnabledInitialization(): bool;

    public function isEnabledAttach(): bool;
}
