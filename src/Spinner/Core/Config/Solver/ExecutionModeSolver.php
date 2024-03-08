<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\ExecutionMode;
use AlecRabbit\Spinner\Contract\Option\ExecutionOption;
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
        ?ExecutionOption $userOption,
        ?ExecutionOption $detectedOption,
        ?ExecutionOption $defaultOption,
    ): ExecutionMode {
        $options = [$userOption, $detectedOption, $defaultOption];

        return match ($options) {
            [
                ExecutionOption::ASYNC,
                ExecutionOption::ASYNC,
                ExecutionOption::ASYNC,
            ],
            [
                ExecutionOption::AUTO,
                ExecutionOption::ASYNC,
                ExecutionOption::ASYNC,
            ],
            [
                ExecutionOption::AUTO,
                ExecutionOption::ASYNC,
                null,
            ],
            [
                ExecutionOption::AUTO,
                null,
                ExecutionOption::ASYNC,
            ],
            [
                null,
                null,
                ExecutionOption::ASYNC,
            ],
            [
                null,
                ExecutionOption::AUTO,
                ExecutionOption::ASYNC,
            ],
            [
                null,
                ExecutionOption::ASYNC,
                null,
            ],
            [
                null,
                ExecutionOption::ASYNC,
                ExecutionOption::ASYNC,
            ],
            [
                ExecutionOption::ASYNC,
                null,
                null,
            ],
            [
                ExecutionOption::ASYNC,
                null,
                ExecutionOption::ASYNC,
            ] => ExecutionMode::ASYNC,
            [
                ExecutionOption::AUTO,
                ExecutionOption::SYNCHRONOUS,
                ExecutionOption::ASYNC,
            ],
            [
                ExecutionOption::SYNCHRONOUS,
                ExecutionOption::ASYNC,
                ExecutionOption::ASYNC,
            ],
            [
                ExecutionOption::AUTO,
                ExecutionOption::SYNCHRONOUS,
                null,
            ],
            [
                ExecutionOption::AUTO,
                null,
                ExecutionOption::SYNCHRONOUS,
            ],
            [
                null,
                null,
                ExecutionOption::SYNCHRONOUS,
            ],
            [
                null,
                ExecutionOption::AUTO,
                ExecutionOption::SYNCHRONOUS,
            ],
            [
                null,
                ExecutionOption::SYNCHRONOUS,
                null,
            ],
            [
                null,
                ExecutionOption::SYNCHRONOUS,
                ExecutionOption::SYNCHRONOUS,
            ],
            [
                ExecutionOption::SYNCHRONOUS,
                null,
                null,
            ],
            [
                ExecutionOption::SYNCHRONOUS,
                null,
                ExecutionOption::ASYNC,
            ],
            [
                null,
                ExecutionOption::SYNCHRONOUS,
                ExecutionOption::ASYNC,
            ],
            [
                ExecutionOption::SYNCHRONOUS,
                ExecutionOption::SYNCHRONOUS,
                ExecutionOption::ASYNC,
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

    protected function extractOption(ISettings $settings): ?ExecutionOption
    {
        return $this->extractSettingsElement($settings, IGeneralSettings::class)?->getExecutionOption();
    }
}
