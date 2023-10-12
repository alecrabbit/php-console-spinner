<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver\Contract;

use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;

interface IWidgetSettingsSolver extends ISolver
{
    public function solve(): IWidgetSettings;
}
