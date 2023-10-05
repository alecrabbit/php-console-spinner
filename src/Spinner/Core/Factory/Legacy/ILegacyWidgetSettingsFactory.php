<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Legacy;

use AlecRabbit\Spinner\Core\Config\Legacy\Contract\ILegacyWidgetConfig;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyWidgetSettings;

/**
 * @deprecated Will be removed
 */
interface ILegacyWidgetSettingsFactory
{
    public function createFromConfig(ILegacyWidgetConfig $config): ILegacyWidgetSettings;
}
