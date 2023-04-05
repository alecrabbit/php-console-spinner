<?php

declare(strict_types=1);
// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;

interface ILoopSettingsBuilder
{
    public function build(): ILoopSettings;
}
