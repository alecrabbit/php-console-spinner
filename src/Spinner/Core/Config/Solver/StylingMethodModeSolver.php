<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IStylingMethodModeSolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final readonly class StylingMethodModeSolver extends ASolver implements IStylingMethodModeSolver
{

    public function solve(): StylingMethodMode
    {
        return
            $this->doSolve(
                $this->extractOption($this->settingsProvider->getSettings()),
                $this->extractOption($this->settingsProvider->getDetectedSettings()),
                $this->extractOption($this->settingsProvider->getDefaultSettings()),
            );
    }

    private function doSolve(
        ?StylingMethodOption $userOption,
        ?StylingMethodOption $detectedOption,
        ?StylingMethodOption $defaultOption
    ): StylingMethodMode {
        throw new InvalidArgumentException(
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

    protected function extractOption(ISettings $settings): ?StylingMethodOption
    {
        return $this->extractSettingsElement($settings, IOutputSettings::class)?->getStylingMethodOption();
    }
}
