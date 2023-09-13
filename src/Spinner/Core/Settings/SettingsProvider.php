<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;

final readonly class SettingsProvider implements ISettingsProvider
{
    public function __construct(
        protected ISettings $userSettings,
        protected ISettings $defaultSettings,
        protected ISettings $detectedSettings,
    ) {
    }

    /** @deprecated */
    public function getUserSettings(): ISettings
    {
        return $this->userSettings;
    }

    /** @deprecated */
    public function getDefaultSettings(): ISettings
    {
        return $this->defaultSettings;
    }

    /** @deprecated */
    public function getDetectedSettings(): ISettings
    {
        return $this->detectedSettings;
    }
}
