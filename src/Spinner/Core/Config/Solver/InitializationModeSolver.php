<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Contract\Option\InitializationOption;
use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final readonly class InitializationModeSolver extends ASolver implements Contract\IInitializationModeSolver
{
    public function solve(): InitializationMode
    {
        return
            $this->doSolve(
                $this->extractOption($this->settingsProvider->getSettings()),
                $this->extractOption($this->settingsProvider->getDetectedSettings()),
                $this->extractOption($this->settingsProvider->getDefaultSettings()),
            );
    }

    private function doSolve(
        ?InitializationOption $userOption,
        ?InitializationOption $detectedOption,
        ?InitializationOption $defaultOption
    ): InitializationMode {
        $options = [$userOption, $detectedOption, $defaultOption];
        return
            match ($options) {
                [
                    InitializationOption::AUTO,
                    InitializationOption::ENABLED,
                    InitializationOption::DISABLED,
                ],
                [
                    InitializationOption::ENABLED,
                    InitializationOption::DISABLED,
                    InitializationOption::DISABLED,
                ],
                [
                    InitializationOption::ENABLED,
                    null,
                    null,
                ],
                [
                    InitializationOption::AUTO,
                    InitializationOption::ENABLED,
                    null,
                ],
                [
                    InitializationOption::AUTO,
                    null,
                    InitializationOption::ENABLED,
                ],
                [
                    null,
                    InitializationOption::AUTO,
                    InitializationOption::ENABLED,
                ],
                [
                    null,
                    InitializationOption::ENABLED,
                    null,
                ],
                [
                    null,
                    InitializationOption::ENABLED,
                    InitializationOption::ENABLED,
                ],
                [
                    null,
                    null,
                    InitializationOption::ENABLED,
                ] => InitializationMode::ENABLED,
                [
                    InitializationOption::AUTO,
                    InitializationOption::DISABLED,
                    InitializationOption::DISABLED,
                ],
                [
                    InitializationOption::DISABLED,
                    InitializationOption::DISABLED,
                    InitializationOption::DISABLED,
                ],
                [
                    InitializationOption::AUTO,
                    InitializationOption::DISABLED,
                    null,
                ],
                [
                    InitializationOption::AUTO,
                    null,
                    InitializationOption::DISABLED,
                ],
                [
                    null,
                    InitializationOption::AUTO,
                    InitializationOption::DISABLED,
                ],
                [
                    null,
                    InitializationOption::DISABLED,
                    null,
                ],
                [
                    null,
                    InitializationOption::DISABLED,
                    InitializationOption::DISABLED,
                ],
                [
                    null,
                    InitializationOption::DISABLED,
                    InitializationOption::ENABLED,
                ],
                [
                    null,
                    InitializationOption::ENABLED,
                    InitializationOption::DISABLED,
                ],
                [
                    InitializationOption::DISABLED,
                    null,
                    null,
                ],
                [
                    null,
                    null,
                    InitializationOption::DISABLED,
                ] => InitializationMode::DISABLED,
                default => throw new InvalidArgumentException(
                    sprintf(
                        'Unable to solve "%s". From values %s.',
                        InitializationMode::class,
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

    protected function extractOption(ISettings $settings): ?InitializationOption
    {
        return $this->extractSettingsElement($settings, IDriverSettings::class)?->getInitializationOption();
    }
}
