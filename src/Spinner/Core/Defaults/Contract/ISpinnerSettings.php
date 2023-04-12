<?php

declare(strict_types=1);
// 12.04.23
namespace AlecRabbit\Spinner\Core\Defaults\Contract;

interface ISpinnerSettings
{
    public function getWidgetSettings(): IWidgetSettings;
}
