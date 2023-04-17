<?php

declare(strict_types=1);

// 12.04.23
namespace AlecRabbit\Spinner\Core\Config\Contract;

interface ISpinnerConfig
{
    public function getWidgetConfig(): IWidgetConfig;
}
