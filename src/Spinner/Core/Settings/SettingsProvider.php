<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;

final readonly class SettingsProvider implements Contract\ISettingsProvider
{
    public function __construct(
        protected ISettings $userSettings,
        protected ISettings $defaultSettings,
        protected ISettings $detectedSettings,
    )
    {
    }

    public function getUserSettings(): ISettings
    {
        return $this->userSettings;
    }

    public function getDefaultSettings(): ISettings
    {
        return $this->defaultSettings;
    }

    public function getDetectedSettings(): ISettings
    {
        return $this->detectedSettings;
    }
}
