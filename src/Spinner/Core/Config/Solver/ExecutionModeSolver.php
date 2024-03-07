<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\ExecutionMode;
use AlecRabbit\Spinner\Contract\Option\ExecutionModeOption;
use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IExecutionModeSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IGeneralSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\InvalidArgument;

use function sprintf;

final readonly class ExecutionModeSolver extends ASolver implements IExecutionModeSolver
{
    public function solve(): ExecutionMode
    {
        return $this->doSolve(
            $this->extractOption($this->settingsProvider->getUserSettings()),
            $this->extractOption($this->settingsProvider->getDetectedSettings()),
            $this->extractOption($this->settingsProvider->getDefaultSettings()),
        );
    }

    /**
     * @throws InvalidArgument
     */
    private function doSolve(
        ?ExecutionModeOption $userOption,
        ?ExecutionModeOption $detectedOption,
        ?ExecutionModeOption $defaultOption,
    ): ExecutionMode {
        $options = [$userOption, $detectedOption, $defaultOption];

        return match ($options) {
            [
                ExecutionModeOption::ASYNC,
                ExecutionModeOption::ASYNC,
                ExecutionModeOption::ASYNC,
            ],
            [
                ExecutionModeOption::AUTO,
                ExecutionModeOption::ASYNC,
                ExecutionModeOption::ASYNC,
            ],
            [
                ExecutionModeOption::AUTO,
                ExecutionModeOption::ASYNC,
                null,
            ],
            [
                ExecutionModeOption::AUTO,
                null,
                ExecutionModeOption::ASYNC,
            ],
            [
                null,
                null,
                ExecutionModeOption::ASYNC,
            ],
            [
                null,
                ExecutionModeOption::AUTO,
                ExecutionModeOption::ASYNC,
            ],
            [
                null,
                ExecutionModeOption::ASYNC,
                null,
            ],
            [
                null,
                ExecutionModeOption::ASYNC,
                ExecutionModeOption::ASYNC,
            ],
            [
                ExecutionModeOption::ASYNC,
                null,
                null,
            ],
            [
                ExecutionModeOption::ASYNC,
                null,
                ExecutionModeOption::ASYNC,
            ] => ExecutionMode::ASYNC,
            [
                ExecutionModeOption::AUTO,
                ExecutionModeOption::SYNCHRONOUS,
                ExecutionModeOption::ASYNC,
            ],
            [
                ExecutionModeOption::SYNCHRONOUS,
                ExecutionModeOption::ASYNC,
                ExecutionModeOption::ASYNC,
            ],
            [
                ExecutionModeOption::AUTO,
                ExecutionModeOption::SYNCHRONOUS,
                null,
            ],
            [
                ExecutionModeOption::AUTO,
                null,
                ExecutionModeOption::SYNCHRONOUS,
            ],
            [
                null,
                null,
                ExecutionModeOption::SYNCHRONOUS,
            ],
            [
                null,
                ExecutionModeOption::AUTO,
                ExecutionModeOption::SYNCHRONOUS,
            ],
            [
                null,
                ExecutionModeOption::SYNCHRONOUS,
                null,
            ],
            [
                null,
                ExecutionModeOption::SYNCHRONOUS,
                ExecutionModeOption::SYNCHRONOUS,
            ],
            [
                ExecutionModeOption::SYNCHRONOUS,
                null,
                null,
            ],
            [
                ExecutionModeOption::SYNCHRONOUS,
                null,
                ExecutionModeOption::ASYNC,
            ],
            [
                null,
                ExecutionModeOption::SYNCHRONOUS,
                ExecutionModeOption::ASYNC,
            ],
            [
                ExecutionModeOption::SYNCHRONOUS,
                ExecutionModeOption::SYNCHRONOUS,
                ExecutionModeOption::ASYNC,
            ] => ExecutionMode::SYNCHRONOUS,
            default // DEFAULT BRANCH
            => throw new InvalidArgument(
                sprintf(
                    'Unable to solve "%s". From values %s.',
                    ExecutionMode::class,
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

    protected function extractOption(ISettings $settings): ?ExecutionModeOption
    {
        return $this->extractSettingsElement($settings, IGeneralSettings::class)?->getExecutionModeOption();
    }
}
