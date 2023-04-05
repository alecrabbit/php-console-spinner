<?php

declare(strict_types=1);
// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Defaults\Contract\ISpinnerSettings;

interface ISpinnerSettingsBuilder
{

    public function build(): ISpinnerSettings;
}
