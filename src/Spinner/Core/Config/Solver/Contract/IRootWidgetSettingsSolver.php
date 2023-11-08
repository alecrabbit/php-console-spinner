<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver\Contract;

use AlecRabbit\Spinner\Core\Settings\Contract\IRootWidgetSettings;

interface IRootWidgetSettingsSolver extends ISolver
{
    public function solve(): IRootWidgetSettings;
}
