<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;

final readonly class SettingsProvider implements ISettingsProvider
{
    public function __construct(
        private ISettings $userSettings,
        private ISettings $defaultSettings,
        private ISettings $detectedSettings,
    ) {
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
