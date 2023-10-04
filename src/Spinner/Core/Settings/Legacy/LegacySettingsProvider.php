<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Legacy;

use AlecRabbit\Spinner\Core\Config\Legacy\Contract\ILegacyWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyLoopSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyTerminalSettings;


/**
 * @deprecated Will be removed
 */
final class LegacySettingsProvider implements ILegacySettingsProvider
{
    public function __construct(
        protected ILegacyAuxSettings $auxSettings,
        protected ILegacyTerminalSettings $terminalSettings,
        protected ILegacyLoopSettings $loopSettings,
        protected ILegacyDriverSettings $driverSettings,
        protected ILegacyWidgetConfig $widgetConfig,
        protected ILegacyWidgetConfig $rootWidgetConfig,
    ) {
    }

    public function getLegacyRootWidgetConfig(): ILegacyWidgetConfig
    {
        return $this->rootWidgetConfig;
    }

    public function getLegacyWidgetConfig(): ILegacyWidgetConfig
    {
        return $this->widgetConfig;
    }

    public function getLegacyDriverSettings(): ILegacyDriverSettings
    {
        return $this->driverSettings;
    }

    public function getLegacyLoopSettings(): ILegacyLoopSettings
    {
        return $this->loopSettings;
    }

    public function getLegacyTerminalSettings(): ILegacyTerminalSettings
    {
        return $this->terminalSettings;
    }

    public function getLegacyAuxSettings(): ILegacyAuxSettings
    {
        return $this->auxSettings;
    }
}
