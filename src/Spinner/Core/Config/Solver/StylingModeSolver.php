<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\StylingMode;
use AlecRabbit\Spinner\Contract\Option\StylingOption;
use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IStylingModeSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\InvalidArgument;

final readonly class StylingModeSolver extends ASolver implements IStylingModeSolver
{
    public function solve(): StylingMode
    {
        return $this->doSolve(
            $this->extractOption($this->settingsProvider->getUserSettings()),
            $this->extractOption($this->settingsProvider->getDetectedSettings()),
            $this->extractOption($this->settingsProvider->getDefaultSettings()),
        );
    }

    private function doSolve(
        ?StylingOption $userOption,
        ?StylingOption $detectedOption,
        ?StylingOption $defaultOption
    ): StylingMode {
        if ($detectedOption === StylingOption::NONE) {
            return StylingMode::NONE;
        }

        $mode = $this->createModeFromOption($userOption);

        $detectedMode = $this->createModeFromOption($detectedOption);
        $defaultMode = $this->createModeFromOption($defaultOption);

        if ($userOption === StylingOption::AUTO || $userOption === null) {
            $mode = $detectedMode ?? $defaultMode;
        }

        /**
         * @psalm-suppress TypeDoesNotContainNull
         * @psalm-suppress RedundantCondition
         */
        if ($detectedMode !== null && ($mode?->value > $detectedMode?->value)) {
            $mode = $detectedMode;
        }

        if ($mode instanceof StylingMode) {
            return $mode;
        }

        throw new InvalidArgument(
            sprintf(
                'Unable to solve "%s". From values %s.',
                StylingMode::class,
                sprintf(
                    '[%s, %s, %s]',
                    $userOption?->name ?? 'null',
                    $detectedOption?->name ?? 'null',
                    $defaultOption?->name ?? 'null',
                ),
            )
        );
    }

    private function createModeFromOption(?StylingOption $option): ?StylingMode
    {
        return match ($option) {
            StylingOption::NONE => StylingMode::NONE,
            StylingOption::ANSI4 => StylingMode::ANSI4,
            StylingOption::ANSI8 => StylingMode::ANSI8,
            StylingOption::ANSI24 => StylingMode::ANSI24,
            default => null,
        };
    }

    protected function extractOption(ISettings $settings): ?StylingOption
    {
        return $this->extractSettingsElement($settings, IOutputSettings::class)?->getStylingOption();
    }
}
