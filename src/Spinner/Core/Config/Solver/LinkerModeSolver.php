<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Contract\Option\LinkerOption;
use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final readonly class LinkerModeSolver extends ASolver implements Contract\ILinkerModeSolver
{
    public function solve(): LinkerMode
    {
        return
            $this->doSolve(
                $this->extractOption($this->settingsProvider->getUserSettings()),
                $this->extractOption($this->settingsProvider->getDetectedSettings()),
                $this->extractOption($this->settingsProvider->getDefaultSettings()),
            );
    }

    private function doSolve(
        ?LinkerOption $userOption,
        ?LinkerOption $detectedOption,
        ?LinkerOption $defaultOption
    ): LinkerMode {
        $options = [$userOption, $detectedOption, $defaultOption];
        return
            match ($options) {
                [
                    LinkerOption::AUTO,
                    LinkerOption::ENABLED,
                    LinkerOption::DISABLED,
                ],
                [
                    LinkerOption::ENABLED,
                    LinkerOption::DISABLED,
                    LinkerOption::DISABLED,
                ],
                [
                    LinkerOption::ENABLED,
                    null,
                    null,
                ],
                [
                    LinkerOption::AUTO,
                    LinkerOption::ENABLED,
                    null,
                ],
                [
                    LinkerOption::AUTO,
                    null,
                    LinkerOption::ENABLED,
                ],
                [
                    null,
                    LinkerOption::AUTO,
                    LinkerOption::ENABLED,
                ],
                [
                    null,
                    LinkerOption::ENABLED,
                    null,
                ],
                [
                    null,
                    LinkerOption::ENABLED,
                    LinkerOption::ENABLED,
                ],
                [
                    null,
                    null,
                    LinkerOption::ENABLED,
                ] => LinkerMode::ENABLED,
                [
                    LinkerOption::AUTO,
                    LinkerOption::DISABLED,
                    LinkerOption::DISABLED,
                ],
                [
                    LinkerOption::DISABLED,
                    LinkerOption::DISABLED,
                    LinkerOption::DISABLED,
                ],
                [
                    LinkerOption::AUTO,
                    LinkerOption::DISABLED,
                    null,
                ],
                [
                    LinkerOption::AUTO,
                    null,
                    LinkerOption::DISABLED,
                ],
                [
                    null,
                    LinkerOption::AUTO,
                    LinkerOption::DISABLED,
                ],
                [
                    null,
                    LinkerOption::DISABLED,
                    null,
                ],
                [
                    null,
                    LinkerOption::DISABLED,
                    LinkerOption::DISABLED,
                ],
                [
                    null,
                    LinkerOption::DISABLED,
                    LinkerOption::ENABLED,
                ],
                [
                    null,
                    LinkerOption::ENABLED,
                    LinkerOption::DISABLED,
                ],
                [
                    LinkerOption::DISABLED,
                    null,
                    null,
                ],
                [
                    null,
                    null,
                    LinkerOption::DISABLED,
                ] => LinkerMode::DISABLED,
                default => throw new InvalidArgumentException(
                    sprintf(
                        'Unable to solve "%s". From values %s.',
                        LinkerMode::class,
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

    protected function extractOption(ISettings $settings): ?LinkerOption
    {
        return $this->extractSettingsElement($settings, IDriverSettings::class)?->getLinkerOption();
    }
}
