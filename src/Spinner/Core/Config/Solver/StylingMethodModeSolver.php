<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Contract\Option\StylingModeOption;
use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IStylingMethodModeSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\InvalidArgument;

final readonly class StylingMethodModeSolver extends ASolver implements IStylingMethodModeSolver
{
    public function solve(): StylingMethodMode
    {
        return $this->doSolve(
            $this->extractOption($this->settingsProvider->getUserSettings()),
            $this->extractOption($this->settingsProvider->getDetectedSettings()),
            $this->extractOption($this->settingsProvider->getDefaultSettings()),
        );
    }

    private function doSolve(
        ?StylingModeOption $userOption,
        ?StylingModeOption $detectedOption,
        ?StylingModeOption $defaultOption
    ): StylingMethodMode {
        if ($detectedOption === StylingModeOption::NONE) {
            return StylingMethodMode::NONE;
        }

        $mode = $this->createModeFromOption($userOption);

        $detectedMode = $this->createModeFromOption($detectedOption);
        $defaultMode = $this->createModeFromOption($defaultOption);

        if ($userOption === StylingModeOption::AUTO || $userOption === null) {
            $mode = $detectedMode ?? $defaultMode;
        }

        /**
         * @psalm-suppress TypeDoesNotContainNull
         * @psalm-suppress RedundantCondition
         */
        if ($detectedMode !== null && ($mode?->value > $detectedMode?->value)) {
            $mode = $detectedMode;
        }

        if ($mode instanceof StylingMethodMode) {
            return $mode;
        }

        throw new InvalidArgument(
            sprintf(
                'Unable to solve "%s". From values %s.',
                StylingMethodMode::class,
                sprintf(
                    '[%s, %s, %s]',
                    $userOption?->name ?? 'null',
                    $detectedOption?->name ?? 'null',
                    $defaultOption?->name ?? 'null',
                ),
            )
        );
    }

    private function createModeFromOption(?StylingModeOption $option): ?StylingMethodMode
    {
        return match ($option) {
            StylingModeOption::NONE => StylingMethodMode::NONE,
            StylingModeOption::ANSI4 => StylingMethodMode::ANSI4,
            StylingModeOption::ANSI8 => StylingMethodMode::ANSI8,
            StylingModeOption::ANSI24 => StylingMethodMode::ANSI24,
            default => null,
        };
    }

    protected function extractOption(ISettings $settings): ?StylingModeOption
    {
        return $this->extractSettingsElement($settings, IOutputSettings::class)?->getStylingModeOption();
    }
}
