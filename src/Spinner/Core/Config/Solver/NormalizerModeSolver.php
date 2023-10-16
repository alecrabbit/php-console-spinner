<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\INormalizerModeSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final readonly class NormalizerModeSolver extends ASolver implements INormalizerModeSolver
{
    public function solve(): NormalizerMode
    {
        return
            $this->doSolve(
                $this->extractOption($this->settingsProvider->getUserSettings()),
                $this->extractOption($this->settingsProvider->getDetectedSettings()),
                $this->extractOption($this->settingsProvider->getDefaultSettings()),
            );
    }

    private function doSolve(
        ?NormalizerOption $userOption,
        ?NormalizerOption $detectedOption,
        ?NormalizerOption $defaultOption
    ): NormalizerMode {
        $mode = $this->createModeFromOption($userOption);

        if ($userOption === NormalizerOption::AUTO || $userOption === null) {
            $mode = $this->createModeFromOption($defaultOption);
        }

        if ($mode instanceof NormalizerMode) {
            return $mode;
        }

        throw new InvalidArgumentException(
            sprintf(
                'Unable to solve "%s". From values %s.',
                NormalizerMode::class,
                sprintf(
                    '[%s, %s, %s]',
                    $userOption?->name ?? 'null',
                    $detectedOption?->name ?? 'null',
                    $defaultOption?->name ?? 'null',
                ),
            )
        );
    }

    private function createModeFromOption(?NormalizerOption $option): ?NormalizerMode
    {
        return
            match ($option) {
                NormalizerOption::SMOOTH => NormalizerMode::SMOOTH,
                NormalizerOption::BALANCED => NormalizerMode::BALANCED,
                NormalizerOption::PERFORMANCE => NormalizerMode::PERFORMANCE,
                NormalizerOption::SLOW => NormalizerMode::SLOW,
                NormalizerOption::STILL => NormalizerMode::STILL,
                default => null,
            };
    }

    protected function extractOption(ISettings $settings): ?NormalizerOption
    {
        return $this->extractSettingsElement($settings, IAuxSettings::class)?->getNormalizerOption();
    }
}
