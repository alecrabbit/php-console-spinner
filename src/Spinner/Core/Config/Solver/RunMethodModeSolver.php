<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IRunMethodModeSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\InvalidArgument;

use function sprintf;

final readonly class RunMethodModeSolver extends ASolver implements IRunMethodModeSolver
{
    /** @inheritDoc */
    public function solve(): RunMethodMode
    {
        return
            $this->doSolve(
                $this->extractOption($this->settingsProvider->getUserSettings()),
                $this->extractOption($this->settingsProvider->getDetectedSettings()),
                $this->extractOption($this->settingsProvider->getDefaultSettings()),
            );
    }

    /**
     * @throws InvalidArgument
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
                    RunMethodOption::ASYNC,
                    RunMethodOption::ASYNC,
                    RunMethodOption::ASYNC,
                ],
                [
                    RunMethodOption::AUTO,
                    RunMethodOption::ASYNC,
                    RunMethodOption::ASYNC,
                ],
                [
                    RunMethodOption::AUTO,
                    RunMethodOption::ASYNC,
                    null,
                ],
                [
                    RunMethodOption::AUTO,
                    null,
                    RunMethodOption::ASYNC,
                ],
                [
                    null,
                    null,
                    RunMethodOption::ASYNC,
                ],
                [
                    null,
                    RunMethodOption::AUTO,
                    RunMethodOption::ASYNC,
                ],
                [
                    null,
                    RunMethodOption::ASYNC,
                    null,
                ],
                [
                    null,
                    RunMethodOption::ASYNC,
                    RunMethodOption::ASYNC,
                ],
                [
                    RunMethodOption::ASYNC,
                    null,
                    null,
                ],
                [
                    RunMethodOption::ASYNC,
                    null,
                    RunMethodOption::ASYNC,
                ]
                => RunMethodMode::ASYNC,
                [
                    RunMethodOption::AUTO,
                    RunMethodOption::SYNCHRONOUS,
                    RunMethodOption::ASYNC,
                ],
                [
                    RunMethodOption::SYNCHRONOUS,
                    RunMethodOption::ASYNC,
                    RunMethodOption::ASYNC,
                ],
                [
                    RunMethodOption::AUTO,
                    RunMethodOption::SYNCHRONOUS,
                    null,
                ],
                [
                    RunMethodOption::AUTO,
                    null,
                    RunMethodOption::SYNCHRONOUS,
                ],
                [
                    null,
                    null,
                    RunMethodOption::SYNCHRONOUS,
                ],
                [
                    null,
                    RunMethodOption::AUTO,
                    RunMethodOption::SYNCHRONOUS,
                ],
                [
                    null,
                    RunMethodOption::SYNCHRONOUS,
                    null,
                ],
                [
                    null,
                    RunMethodOption::SYNCHRONOUS,
                    RunMethodOption::SYNCHRONOUS,
                ],
                [
                    RunMethodOption::SYNCHRONOUS,
                    null,
                    null,
                ],
                [
                    RunMethodOption::SYNCHRONOUS,
                    null,
                    RunMethodOption::ASYNC,
                ],
                [
                    null,
                    RunMethodOption::SYNCHRONOUS,
                    RunMethodOption::ASYNC,
                ],
                [
                    RunMethodOption::SYNCHRONOUS,
                    RunMethodOption::SYNCHRONOUS,
                    RunMethodOption::ASYNC,
                ]
                => RunMethodMode::SYNCHRONOUS,
                default // DEFAULT BRANCH
                => throw new InvalidArgument(
                    sprintf(
                        'Unable to solve "%s". From values %s.',
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
        return $this->extractSettingsElement($settings, IAuxSettings::class)?->getRunMethodOption();
    }

}
