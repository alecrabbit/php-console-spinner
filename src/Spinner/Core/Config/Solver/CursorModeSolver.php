<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\CursorMode;
use AlecRabbit\Spinner\Contract\Option\CursorOption;
use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\InvalidArgument;

final readonly class CursorModeSolver extends ASolver implements Contract\ICursorModeSolver
{
    public function solve(): CursorMode
    {
        return $this->doSolve(
            $this->extractOption($this->settingsProvider->getUserSettings()),
            $this->extractOption($this->settingsProvider->getDetectedSettings()),
            $this->extractOption($this->settingsProvider->getDefaultSettings()),
        );
    }

    private function doSolve(
        ?CursorOption $userOption,
        ?CursorOption $detectedOption,
        ?CursorOption $defaultOption
    ): CursorMode {
        $options = [$userOption, $detectedOption, $defaultOption];

        return match ($options) {
            [
                CursorOption::VISIBLE,
                CursorOption::VISIBLE,
                CursorOption::VISIBLE,
            ],
            [
                CursorOption::VISIBLE,
                CursorOption::AUTO,
                CursorOption::HIDDEN,
            ],
            [
                CursorOption::AUTO,
                CursorOption::VISIBLE,
                CursorOption::VISIBLE,
            ],
            [
                CursorOption::AUTO,
                CursorOption::VISIBLE,
                null,
            ],
            [
                CursorOption::AUTO,
                null,
                CursorOption::VISIBLE,
            ],
            [
                null,
                null,
                CursorOption::VISIBLE,
            ],
            [
                null,
                CursorOption::AUTO,
                CursorOption::VISIBLE,
            ],
            [
                null,
                CursorOption::VISIBLE,
                null,
            ],
            [
                null,
                CursorOption::VISIBLE,
                CursorOption::VISIBLE,
            ],
            [
                CursorOption::VISIBLE,
                null,
                CursorOption::HIDDEN,
            ],
            [
                CursorOption::VISIBLE,
                null,
                null,
            ] => CursorMode::VISIBLE,
            [
                CursorOption::AUTO,
                CursorOption::HIDDEN,
                CursorOption::VISIBLE,
            ],
            [
                CursorOption::HIDDEN,
                CursorOption::VISIBLE,
                CursorOption::VISIBLE,
            ],
            [
                CursorOption::AUTO,
                CursorOption::HIDDEN,
                null,
            ],
            [
                CursorOption::AUTO,
                null,
                CursorOption::HIDDEN,
            ],
            [
                CursorOption::AUTO,
                CursorOption::AUTO,
                CursorOption::HIDDEN,
            ],
            [
                null,
                null,
                CursorOption::HIDDEN,
            ],
            [
                null,
                CursorOption::AUTO,
                CursorOption::HIDDEN,
            ],
            [
                null,
                CursorOption::HIDDEN,
                null,
            ],
            [
                null,
                CursorOption::HIDDEN,
                CursorOption::HIDDEN,
            ],
            [
                CursorOption::HIDDEN,
                null,
                null,
            ] => CursorMode::HIDDEN,
            default // DEFAULT BRANCH
            => throw new InvalidArgument(
                sprintf(
                    'Unable to solve "%s". From values %s.',
                    CursorMode::class,
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

    protected function extractOption(ISettings $settings): ?CursorOption
    {
        return $this->extractSettingsElement($settings, IOutputSettings::class)?->getCursorOption();
    }
}
