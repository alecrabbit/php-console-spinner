<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\DriverMode;
use AlecRabbit\Spinner\Contract\Option\DriverOption;
use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\InvalidArgument;

final readonly class DriverModeSolver extends ASolver implements Contract\IDriverModeSolver
{
    public function solve(): DriverMode
    {
        return $this->doSolve(
            $this->extractOption($this->settingsProvider->getUserSettings()),
            $this->extractOption($this->settingsProvider->getDetectedSettings()),
            $this->extractOption($this->settingsProvider->getDefaultSettings()),
        );
    }

    private function doSolve(
        ?DriverOption $userOption,
        ?DriverOption $detectedOption,
        ?DriverOption $defaultOption
    ): DriverMode {
        $options = [$userOption, $detectedOption, $defaultOption];
        dump($options);
        return match ($options) {
            [
                DriverOption::AUTO,
                DriverOption::ENABLED,
                DriverOption::DISABLED,
            ],
            [
                DriverOption::AUTO,
                DriverOption::ENABLED,
                DriverOption::ENABLED,
            ],
            [
                DriverOption::ENABLED,
                DriverOption::ENABLED,
                DriverOption::ENABLED,
            ],
            [
                DriverOption::ENABLED,
                null,
                DriverOption::ENABLED,
            ],
            [
                DriverOption::ENABLED,
                DriverOption::DISABLED,
                DriverOption::DISABLED,
            ],
            [
                DriverOption::ENABLED,
                null,
                null,
            ],
            [
                DriverOption::AUTO,
                DriverOption::ENABLED,
                null,
            ],
            [
                DriverOption::AUTO,
                null,
                DriverOption::ENABLED,
            ],
            [
                null,
                DriverOption::AUTO,
                DriverOption::ENABLED,
            ],
            [
                null,
                DriverOption::ENABLED,
                null,
            ],
            [
                null,
                DriverOption::ENABLED,
                DriverOption::ENABLED,
            ],
            [
                null,
                null,
                DriverOption::ENABLED,
            ] => DriverMode::ENABLED,
            [
                DriverOption::AUTO,
                DriverOption::DISABLED,
                DriverOption::DISABLED,
            ],
            [
                DriverOption::DISABLED,
                DriverOption::DISABLED,
                DriverOption::DISABLED,
            ],
            [
                DriverOption::DISABLED,
                null,
                DriverOption::ENABLED,
            ],
            [
                DriverOption::AUTO,
                DriverOption::DISABLED,
                null,
            ],
            [
                DriverOption::AUTO,
                null,
                DriverOption::DISABLED,
            ],
            [
                null,
                DriverOption::AUTO,
                DriverOption::DISABLED,
            ],
            [
                null,
                DriverOption::DISABLED,
                null,
            ],
            [
                null,
                DriverOption::DISABLED,
                DriverOption::DISABLED,
            ],
            [
                null,
                DriverOption::DISABLED,
                DriverOption::ENABLED,
            ],
            [
                null,
                DriverOption::ENABLED,
                DriverOption::DISABLED,
            ],
            [
                DriverOption::DISABLED,
                DriverOption::ENABLED,
                DriverOption::ENABLED,
            ],
            [
                DriverOption::DISABLED,
                null,
                null,
            ],
            [
                null,
                null,
                DriverOption::DISABLED,
            ] => DriverMode::DISABLED,
            default => throw new InvalidArgument(
                sprintf(
                    'Unable to solve "%s". From values %s.',
                    DriverMode::class,
                    sprintf(
                        '[%s, %s, %s]',
                        $userOption?->name ?? 'null',
                        $detectedOption?->name ?? 'null',
                        $defaultOption?->name ?? 'null',
                    ),
                )
            )
        };
    }

    protected function extractOption(ISettings $settings): ?DriverOption
    {
        return $this->extractSettingsElement($settings, IDriverSettings::class)?->getDriverOption();
    }
}
