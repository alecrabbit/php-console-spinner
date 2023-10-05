<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Builder;

use AlecRabbit\Spinner\Core\Settings\Contract\Builder\ISettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\SettingsProvider;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class SettingsProviderBuilder implements ISettingsProviderBuilder
{
    private ?ISettings $settings = null;
    private ?ISettings $defaultSettings = null;
    private ?ISettings $detectedSettings = null;


    public function build(): ISettingsProvider
    {
        $this->validate();

        return
            new SettingsProvider(
                settings: $this->settings,
                defaultSettings: $this->defaultSettings,
                detectedSettings: $this->detectedSettings,
            );
    }

    private function validate(): void
    {
        match (true) {
            $this->settings === null => throw new LogicException('User settings are not set.'),
            $this->defaultSettings === null => throw new LogicException('Default settings are not set.'),
            $this->detectedSettings === null => throw new LogicException('Detected settings are not set.'),
            default => null,
        };
    }

    public function withSettings(ISettings $settings): ISettingsProviderBuilder
    {
        $clone = clone $this;
        $clone->settings = $settings;
        return $clone;
    }

    public function withDefaultSettings(ISettings $settings): ISettingsProviderBuilder
    {
        $clone = clone $this;
        $clone->defaultSettings = $settings;
        return $clone;
    }

    public function withDetectedSettings(ISettings $settings): ISettingsProviderBuilder
    {
        $clone = clone $this;
        $clone->detectedSettings = $settings;
        return $clone;
    }
}
