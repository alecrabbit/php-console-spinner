<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\INormalizerMethodModeSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final readonly class NormalizerMethodModeSolver extends ASolver implements INormalizerMethodModeSolver
{
    public function solve(): NormalizerMethodMode
    {
        return
            $this->doSolve(
                $this->extractOption($this->settingsProvider->getSettings()),
                $this->extractOption($this->settingsProvider->getDetectedSettings()),
                $this->extractOption($this->settingsProvider->getDefaultSettings()),
            );
    }

    private function doSolve(
        ?NormalizerOption $userOption,
        ?NormalizerOption $detectedOption,
        ?NormalizerOption $defaultOption
    ): NormalizerMethodMode {
        $mode = $this->createModeFromOption($userOption);

        if ($userOption === NormalizerOption::AUTO || $userOption === null) {
            $mode = $this->createModeFromOption($defaultOption);
        }

        if ($mode instanceof NormalizerMethodMode) {
            return $mode;
        }

        throw new InvalidArgumentException(
            sprintf(
                'Unable to solve "%s". From values %s.',
                NormalizerMethodMode::class,
                sprintf(
                    '[%s, %s, %s]',
                    $userOption?->name ?? 'null',
                    $detectedOption?->name ?? 'null',
                    $defaultOption?->name ?? 'null',
                ),
            )
        );
    }

    private function createModeFromOption(?NormalizerOption $option): ?NormalizerMethodMode
    {
        return
            match ($option) {
                NormalizerOption::SMOOTH => NormalizerMethodMode::SMOOTH,
                NormalizerOption::BALANCED => NormalizerMethodMode::BALANCED,
                NormalizerOption::PERFORMANCE => NormalizerMethodMode::PERFORMANCE,
                NormalizerOption::SLOW => NormalizerMethodMode::SLOW,
                NormalizerOption::STILL => NormalizerMethodMode::STILL,
                default => null,
            };
    }

    protected function extractOption(ISettings $settings): ?NormalizerOption
    {
        return $this->extractSettingsElement($settings, IAuxSettings::class)?->getNormalizerOption();
    }
}
