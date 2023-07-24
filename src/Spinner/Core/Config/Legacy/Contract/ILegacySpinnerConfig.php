<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Config\Legacy\Contract;

interface ILegacySpinnerConfig
{
    public function getWidgetConfig(): ILegacyWidgetConfig;
}
