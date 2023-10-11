<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\SignalHandlersMode;
use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;
use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final readonly class SignalHandlersModeSolver extends ASolver implements Contract\ISignalHandlersModeSolver
{

    public function solve(): SignalHandlersMode
    {
        return
            $this->doSolve(
                $this->extractOption($this->settingsProvider->getUserSettings()),
                $this->extractOption($this->settingsProvider->getDetectedSettings()),
                $this->extractOption($this->settingsProvider->getDefaultSettings()),
            );
    }

    private function doSolve(
        ?SignalHandlersOption $userOption,
        ?SignalHandlersOption $detectedOption,
        ?SignalHandlersOption $defaultOption
    ): SignalHandlersMode {
        $options = [$userOption, $detectedOption, $defaultOption];
        return
            match ($options) {
                [
                    SignalHandlersOption::AUTO,
                    SignalHandlersOption::ENABLED,
                    SignalHandlersOption::DISABLED,
                ],
                [
                    SignalHandlersOption::ENABLED,
                    SignalHandlersOption::DISABLED,
                    SignalHandlersOption::DISABLED,
                ],
                [
                    SignalHandlersOption::ENABLED,
                    null,
                    null,
                ],
                [
                    SignalHandlersOption::AUTO,
                    SignalHandlersOption::ENABLED,
                    null,
                ],
                [
                    SignalHandlersOption::AUTO,
                    null,
                    SignalHandlersOption::ENABLED,
                ],
                [
                    null,
                    SignalHandlersOption::AUTO,
                    SignalHandlersOption::ENABLED,
                ],
                [
                    null,
                    SignalHandlersOption::ENABLED,
                    null,
                ],
                [
                    null,
                    SignalHandlersOption::ENABLED,
                    SignalHandlersOption::ENABLED,
                ],
                [
                    null,
                    null,
                    SignalHandlersOption::ENABLED,
                ] => SignalHandlersMode::ENABLED,
                [
                    SignalHandlersOption::AUTO,
                    SignalHandlersOption::DISABLED,
                    SignalHandlersOption::DISABLED,
                ],
                [
                    SignalHandlersOption::DISABLED,
                    SignalHandlersOption::DISABLED,
                    SignalHandlersOption::DISABLED,
                ],
                [
                    SignalHandlersOption::AUTO,
                    SignalHandlersOption::DISABLED,
                    null,
                ],
                [
                    SignalHandlersOption::AUTO,
                    null,
                    SignalHandlersOption::DISABLED,
                ],
                [
                    null,
                    SignalHandlersOption::AUTO,
                    SignalHandlersOption::DISABLED,
                ],
                [
                    null,
                    SignalHandlersOption::DISABLED,
                    null,
                ],
                [
                    null,
                    SignalHandlersOption::DISABLED,
                    SignalHandlersOption::DISABLED,
                ],
                [
                    null,
                    SignalHandlersOption::ENABLED,
                    SignalHandlersOption::DISABLED,
                ],
                [
                    null,
                    SignalHandlersOption::DISABLED,
                    SignalHandlersOption::ENABLED,
                ],
                [
                    SignalHandlersOption::DISABLED,
                    null,
                    null,
                ],
                [
                    null,
                    null,
                    SignalHandlersOption::DISABLED,
                ] => SignalHandlersMode::DISABLED,
                default => throw new InvalidArgumentException(
                    sprintf(
                        'Unable to solve "%s". From values %s.',
                        SignalHandlersMode::class,
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

    protected function extractOption(ISettings $settings): ?SignalHandlersOption
    {
        return $this->extractSettingsElement($settings, ILoopSettings::class)?->getSignalHandlersOption();
    }
}
