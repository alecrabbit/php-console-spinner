<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Legacy\Contract;

/**
 * @deprecated Will be removed
 */
interface ILegacySpinnerConfig
{
    public function getWidgetConfig(): ILegacyWidgetConfig;
}
