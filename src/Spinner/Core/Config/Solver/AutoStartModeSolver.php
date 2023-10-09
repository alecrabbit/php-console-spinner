<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Contract\Option\AutoStartOption;
use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IAutoStartModeSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final readonly class AutoStartModeSolver extends ASolver implements IAutoStartModeSolver
{

    public function solve(): AutoStartMode
    {
        return
            $this->doSolve(
                $this->extractOption($this->settingsProvider->getUserSettings()),
                $this->extractOption($this->settingsProvider->getDetectedSettings()),
                $this->extractOption($this->settingsProvider->getDefaultSettings()),
            );
    }

    private function doSolve(
        ?AutoStartOption $userOption,
        ?AutoStartOption $detectedOption,
        ?AutoStartOption $defaultOption
    ): AutoStartMode {
        $options = [$userOption, $detectedOption, $defaultOption];
        return
            match ($options) {
                [
                    AutoStartOption::AUTO,
                    AutoStartOption::ENABLED,
                    AutoStartOption::DISABLED,
                ],
                [
                    AutoStartOption::ENABLED,
                    AutoStartOption::DISABLED,
                    AutoStartOption::DISABLED,
                ],
                [
                    AutoStartOption::ENABLED,
                    null,
                    null,
                ],
                [
                    AutoStartOption::AUTO,
                    AutoStartOption::ENABLED,
                    null,
                ],
                [
                    AutoStartOption::AUTO,
                    null,
                    AutoStartOption::ENABLED,
                ],
                [
                    null,
                    AutoStartOption::AUTO,
                    AutoStartOption::ENABLED,
                ],
                [
                    null,
                    AutoStartOption::ENABLED,
                    null,
                ],
                [
                    null,
                    AutoStartOption::ENABLED,
                    AutoStartOption::ENABLED,
                ],
                [
                    null,
                    null,
                    AutoStartOption::ENABLED,
                ] => AutoStartMode::ENABLED,
                [
                    AutoStartOption::AUTO,
                    AutoStartOption::DISABLED,
                    AutoStartOption::DISABLED,
                ],
                [
                    AutoStartOption::DISABLED,
                    AutoStartOption::DISABLED,
                    AutoStartOption::DISABLED,
                ],
                [
                    AutoStartOption::AUTO,
                    AutoStartOption::DISABLED,
                    null,
                ],
                [
                    AutoStartOption::AUTO,
                    null,
                    AutoStartOption::DISABLED,
                ],
                [
                    null,
                    AutoStartOption::AUTO,
                    AutoStartOption::DISABLED,
                ],
                [
                    null,
                    AutoStartOption::DISABLED,
                    null,
                ],
                [
                    null,
                    AutoStartOption::DISABLED,
                    AutoStartOption::DISABLED,
                ],
                [
                    null,
                    AutoStartOption::DISABLED,
                    AutoStartOption::ENABLED,
                ],
                [
                    null,
                    AutoStartOption::ENABLED,
                    AutoStartOption::DISABLED,
                ],
                [
                    AutoStartOption::DISABLED,
                    null,
                    null,
                ],
                [
                    null,
                    null,
                    AutoStartOption::DISABLED,
                ] => AutoStartMode::DISABLED,
                default => throw new InvalidArgumentException(
                    sprintf(
                        'Unable to solve "%s". From values %s.',
                        AutoStartMode::class,
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

    protected function extractOption(ISettings $settings): ?AutoStartOption
    {
        return $this->extractSettingsElement($settings, ILoopSettings::class)?->getAutoStartOption();
    }
}
