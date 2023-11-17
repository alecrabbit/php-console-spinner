<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IToleranceSolver;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Tolerance;
use AlecRabbit\Spinner\Core\Settings\Contract\IRevolverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\LogicException;

final readonly class ToleranceSolver extends ASolver implements IToleranceSolver
{
    public function solve(): ITolerance
    {
        return $this->doSolve(
            $this->extractTolerance($this->settingsProvider->getUserSettings()),
            $this->extractTolerance($this->settingsProvider->getDetectedSettings()),
            $this->extractTolerance($this->settingsProvider->getDefaultSettings()),
        );
    }

    private function doSolve(
        ?ITolerance $userTolerance,
        ?ITolerance $detectedTolerance,
        ?ITolerance $defaultTolerance,
    ): ITolerance {
        $tolerance =
            $userTolerance
            ?? $detectedTolerance
            ?? $defaultTolerance
            ?? throw new LogicException(
                sprintf('Unable to solve "%s".', ITolerance::class)
            );

        return new Tolerance(
            value: $tolerance->toMilliseconds(),
        );
    }

    private function extractTolerance(ISettings $settings): ?ITolerance
    {
        return $this->extractSettingsElement($settings, IRevolverSettings::class)?->getTolerance();
    }
}
