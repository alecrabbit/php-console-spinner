<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Factory;

use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IUserSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;

final class UserSettingsFactory implements IUserSettingsFactory
{
    public function create(): ISettings
    {
        $settings = new Settings();

        $this->fill($settings);

        return $settings;
    }

    private function fill(ISettings $settings): void
    {
        $settings->set(
            new AuxSettings(),
            new DriverSettings(),
            new LoopSettings(),
            new OutputSettings(),
            new WidgetSettings(),
            new RootWidgetSettings(),
        );
    }
}
