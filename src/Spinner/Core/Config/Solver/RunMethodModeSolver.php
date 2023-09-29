<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Core\Config\Contract\Solver\IRunMethodModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final class RunMethodModeSolver extends ASolver implements IRunMethodModeSolver
{
    /** @inheritDoc */
    public function solve(): RunMethodMode
    {
        return
            $this->doSolve(
                $this->extractOption($this->settingsProvider->getSettings()),
                $this->extractOption($this->settingsProvider->getDetectedSettings()),
                $this->extractOption($this->settingsProvider->getDefaultSettings()),
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    private function doSolve(
        ?RunMethodOption $userOption,
        ?RunMethodOption $detectedOption,
        ?RunMethodOption $defaultOption,
    ): RunMethodMode {
        $options = [$userOption, $detectedOption, $defaultOption];

        return
            match ($options) {
                [
                    RunMethodOption::ASYNC, // user
                    RunMethodOption::ASYNC, // detected
                    RunMethodOption::ASYNC, // default
                ],
                [
                    RunMethodOption::AUTO, // user
                    RunMethodOption::ASYNC, // detected
                    RunMethodOption::ASYNC, // default
                ],
                [
                    RunMethodOption::AUTO, // user
                    RunMethodOption::ASYNC, // detected
                    null, // default
                ],
                [
                    RunMethodOption::AUTO, // user
                    null, // detected
                    RunMethodOption::ASYNC, // default
                ],
                [
                    null, // user
                    null, // detected
                    RunMethodOption::ASYNC, // default
                ],
                [
                    null, // user
                    RunMethodOption::AUTO, // detected
                    RunMethodOption::ASYNC, // default
                ],
                [
                    null, // user
                    RunMethodOption::ASYNC, // detected
                    null, // default
                ],
                [
                    RunMethodOption::ASYNC, // user
                    null, // detected
                    null, // default
                ]
                => RunMethodMode::ASYNC,
                [
                    RunMethodOption::AUTO, // user
                    RunMethodOption::SYNCHRONOUS, // detected
                    RunMethodOption::ASYNC, // default
                ],
                [
                    RunMethodOption::SYNCHRONOUS, // user
                    RunMethodOption::ASYNC, // detected
                    RunMethodOption::ASYNC, // default
                ],
                [
                    RunMethodOption::AUTO, // user
                    RunMethodOption::SYNCHRONOUS, // detected
                    null, // default
                ],
                [
                    RunMethodOption::AUTO, // user
                    null, // detected
                    RunMethodOption::SYNCHRONOUS, // default
                ],
                [
                    null, // user
                    null, // detected
                    RunMethodOption::SYNCHRONOUS, // default
                ],
                [
                    null, // user
                    RunMethodOption::AUTO, // detected
                    RunMethodOption::SYNCHRONOUS, // default
                ],
                [
                    null, // user
                    RunMethodOption::SYNCHRONOUS, // detected
                    null, // default
                ],
                [
                    RunMethodOption::SYNCHRONOUS, // user
                    null, // detected
                    null, // default
                ]
                => RunMethodMode::SYNCHRONOUS,
                default // DEFAULT BRANCH
                => throw new InvalidArgumentException(
                    \sprintf(
                        'Failed to solve "%s". From values %s.',
                        RunMethodMode::class,
                        sprintf(
                            '[%s, %s, %s]',
                            $userOption?->name ?? 'null',
                            $detectedOption?->name ?? 'null',
                            $defaultOption?->name ?? 'null',
                        ),
                    )
                ),
            };
    }

    protected function extractOption(ISettings $settings): ?RunMethodOption
    {
        return $this->extractElement($settings, IAuxSettings::class)?->getRunMethodOption();
    }

}
