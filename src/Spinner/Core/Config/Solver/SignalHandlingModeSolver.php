<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\SignalHandlingMode;
use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;
use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final readonly class SignalHandlingModeSolver extends ASolver implements Contract\ISignalHandlingModeSolver
{

    public function solve(): SignalHandlingMode
    {
        return
            $this->doSolve(
                $this->extractOption($this->settingsProvider->getUserSettings()),
                $this->extractOption($this->settingsProvider->getDetectedSettings()),
                $this->extractOption($this->settingsProvider->getDefaultSettings()),
            );
    }

    private function doSolve(
        ?SignalHandlingOption $userOption,
        ?SignalHandlingOption $detectedOption,
        ?SignalHandlingOption $defaultOption
    ): SignalHandlingMode {
        $options = [$userOption, $detectedOption, $defaultOption];
        return
            match ($options) {
                [
                    SignalHandlingOption::AUTO,
                    SignalHandlingOption::ENABLED,
                    SignalHandlingOption::DISABLED,
                ],
                [
                    SignalHandlingOption::AUTO,
                    SignalHandlingOption::ENABLED,
                    SignalHandlingOption::ENABLED,
                ],
                [
                    SignalHandlingOption::ENABLED,
                    null,
                    SignalHandlingOption::ENABLED,
                ],
                [
                    SignalHandlingOption::AUTO,
                    SignalHandlingOption::AUTO,
                    SignalHandlingOption::ENABLED,
                ],
                [
                    SignalHandlingOption::ENABLED,
                    SignalHandlingOption::ENABLED,
                    SignalHandlingOption::ENABLED,
                ],
                [
                    SignalHandlingOption::ENABLED,
                    SignalHandlingOption::DISABLED,
                    SignalHandlingOption::DISABLED,
                ],
                [
                    SignalHandlingOption::ENABLED,
                    null,
                    null,
                ],
                [
                    SignalHandlingOption::AUTO,
                    SignalHandlingOption::ENABLED,
                    null,
                ],
                [
                    SignalHandlingOption::AUTO,
                    null,
                    SignalHandlingOption::ENABLED,
                ],
                [
                    null,
                    SignalHandlingOption::AUTO,
                    SignalHandlingOption::ENABLED,
                ],
                [
                    null,
                    SignalHandlingOption::ENABLED,
                    null,
                ],
                [
                    null,
                    SignalHandlingOption::ENABLED,
                    SignalHandlingOption::ENABLED,
                ],
                [
                    null,
                    null,
                    SignalHandlingOption::ENABLED,
                ] => SignalHandlingMode::ENABLED,
                [
                    SignalHandlingOption::AUTO,
                    SignalHandlingOption::DISABLED,
                    SignalHandlingOption::DISABLED,
                ],
                [
                    SignalHandlingOption::DISABLED,
                    SignalHandlingOption::DISABLED,
                    SignalHandlingOption::DISABLED,
                ],
                [
                    SignalHandlingOption::DISABLED,
                    SignalHandlingOption::ENABLED,
                    SignalHandlingOption::ENABLED,
                ],
                [
                    SignalHandlingOption::DISABLED,
                    SignalHandlingOption::ENABLED,
                    SignalHandlingOption::DISABLED,
                ],
                [
                    SignalHandlingOption::AUTO,
                    SignalHandlingOption::DISABLED,
                    null,
                ],
                [
                    SignalHandlingOption::AUTO,
                    null,
                    SignalHandlingOption::DISABLED,
                ],
                [
                    null,
                    SignalHandlingOption::AUTO,
                    SignalHandlingOption::DISABLED,
                ],
                [
                    null,
                    SignalHandlingOption::DISABLED,
                    null,
                ],
                [
                    null,
                    SignalHandlingOption::DISABLED,
                    SignalHandlingOption::DISABLED,
                ],
                [
                    null,
                    SignalHandlingOption::ENABLED,
                    SignalHandlingOption::DISABLED,
                ],
                [
                    null,
                    SignalHandlingOption::DISABLED,
                    SignalHandlingOption::ENABLED,
                ],
                [
                    SignalHandlingOption::DISABLED,
                    SignalHandlingOption::DISABLED,
                    SignalHandlingOption::ENABLED,
                ],
                [
                    SignalHandlingOption::AUTO,
                    SignalHandlingOption::DISABLED,
                    SignalHandlingOption::ENABLED,
                ],
                [
                    SignalHandlingOption::ENABLED,
                    SignalHandlingOption::DISABLED,
                    SignalHandlingOption::ENABLED,
                ],
                [
                    SignalHandlingOption::DISABLED,
                    null,
                    null,
                ],
                [
                    SignalHandlingOption::DISABLED,
                    null,
                    SignalHandlingOption::ENABLED,
                ],
                [
                    null,
                    null,
                    SignalHandlingOption::DISABLED,
                ] => SignalHandlingMode::DISABLED,
                default => throw new InvalidArgumentException(
                    sprintf(
                        'Unable to solve "%s". From values %s.',
                        SignalHandlingMode::class,
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

    protected function extractOption(ISettings $settings): ?SignalHandlingOption
    {
        return $this->extractSettingsElement($settings, ILoopSettings::class)?->getSignalHandlingOption();
    }
}
