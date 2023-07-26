<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Legacy\Contract\ILegacyWidgetConfig;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyLoopSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyTerminalSettings;

interface ILegacySettingsProvider
{
    public function getLegacyAuxSettings(): ILegacyAuxSettings;

    public function getLegacyDriverSettings(): ILegacyDriverSettings;

    public function getLegacyLoopSettings(): ILegacyLoopSettings;

    public function getLegacyWidgetConfig(): ILegacyWidgetConfig;

    public function getLegacyRootWidgetConfig(): ILegacyWidgetConfig;

    public function getLegacyTerminalSettings(): ILegacyTerminalSettings;
}
