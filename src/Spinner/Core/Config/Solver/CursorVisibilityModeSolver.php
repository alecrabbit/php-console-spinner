<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final readonly class CursorVisibilityModeSolver extends ASolver implements Contract\ICursorVisibilityModeSolver
{
    public function solve(): CursorVisibilityMode
    {
        return
            $this->doSolve(
                $this->extractOption($this->settingsProvider->getUserSettings()),
                $this->extractOption($this->settingsProvider->getDetectedSettings()),
                $this->extractOption($this->settingsProvider->getDefaultSettings()),
            );
    }

    private function doSolve(
        ?CursorVisibilityOption $userOption,
        ?CursorVisibilityOption $detectedOption,
        ?CursorVisibilityOption $defaultOption
    ): CursorVisibilityMode {
        $options = [$userOption, $detectedOption, $defaultOption];

        return
            match ($options) {
                [
                    CursorVisibilityOption::VISIBLE,
                    CursorVisibilityOption::VISIBLE,
                    CursorVisibilityOption::VISIBLE,
                ],
                [
                    CursorVisibilityOption::AUTO,
                    CursorVisibilityOption::VISIBLE,
                    CursorVisibilityOption::VISIBLE,
                ],
                [
                    CursorVisibilityOption::AUTO,
                    CursorVisibilityOption::VISIBLE,
                    null,
                ],
                [
                    CursorVisibilityOption::AUTO,
                    null,
                    CursorVisibilityOption::VISIBLE,
                ],
                [
                    null,
                    null,
                    CursorVisibilityOption::VISIBLE,
                ],
                [
                    null,
                    CursorVisibilityOption::AUTO,
                    CursorVisibilityOption::VISIBLE,
                ],
                [
                    null,
                    CursorVisibilityOption::VISIBLE,
                    null,
                ],
                [
                    null,
                    CursorVisibilityOption::VISIBLE,
                    CursorVisibilityOption::VISIBLE,
                ],
                [
                    CursorVisibilityOption::VISIBLE,
                    null,
                    null,
                ]
                => CursorVisibilityMode::VISIBLE,
                [
                    CursorVisibilityOption::AUTO,
                    CursorVisibilityOption::HIDDEN,
                    CursorVisibilityOption::VISIBLE,
                ],
                [
                    CursorVisibilityOption::HIDDEN,
                    CursorVisibilityOption::VISIBLE,
                    CursorVisibilityOption::VISIBLE,
                ],
                [
                    CursorVisibilityOption::AUTO,
                    CursorVisibilityOption::HIDDEN,
                    null,
                ],
                [
                    CursorVisibilityOption::AUTO,
                    null,
                    CursorVisibilityOption::HIDDEN,
                ],
                [
                    null,
                    null,
                    CursorVisibilityOption::HIDDEN,
                ],
                [
                    null,
                    CursorVisibilityOption::AUTO,
                    CursorVisibilityOption::HIDDEN,
                ],
                [
                    null,
                    CursorVisibilityOption::HIDDEN,
                    null,
                ],
                [
                    null,
                    CursorVisibilityOption::HIDDEN,
                    CursorVisibilityOption::HIDDEN,
                ],
                [
                    CursorVisibilityOption::HIDDEN,
                    null,
                    null,
                ]
                => CursorVisibilityMode::HIDDEN,
                default // DEFAULT BRANCH
                => throw new InvalidArgumentException(
                    sprintf(
                        'Unable to solve "%s". From values %s.',
                        CursorVisibilityMode::class,
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

    protected function extractOption(ISettings $settings): ?CursorVisibilityOption
    {
        return $this->extractSettingsElement($settings, IOutputSettings::class)?->getCursorVisibilityOption();
    }

}
