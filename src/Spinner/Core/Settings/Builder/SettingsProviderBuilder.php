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

    public function build(): ISettingsProvider
    {
        $this->validate();

        return
            new SettingsProvider(
                settings: $this->settings,
            );
    }

    private function validate(): void
    {
        match (true) {
            $this->settings === null => throw new LogicException('User settings are not set.'),
            default => null,
        };
    }

    public function withSettings(ISettings $settings): ISettingsProviderBuilder
    {
        $clone = clone $this;
        $clone->settings = $settings;
        return $clone;
    }
}
