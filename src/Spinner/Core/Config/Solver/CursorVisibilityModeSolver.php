<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;

final readonly class CursorVisibilityModeSolver extends ASolver implements Contract\ICursorVisibilityModeSolver
{
    public function solve(): CursorVisibilityMode
    {
        return
            $this->doSolve(
                $this->extractOption($this->settingsProvider->getSettings()),
                $this->extractOption($this->settingsProvider->getDetectedSettings()),
                $this->extractOption($this->settingsProvider->getDefaultSettings()),
            );
    }

    private function doSolve(
        ?CursorVisibilityOption $userOption,
        ?CursorVisibilityOption $detectedOption,
        ?CursorVisibilityOption $defaultOption
    ): CursorVisibilityMode {
        return CursorVisibilityMode::HIDDEN;
    }

    protected function extractOption(ISettings $settings): ?CursorVisibilityOption
    {
        return $this->extractSettingsElement($settings, IOutputSettings::class)?->getCursorVisibilityOption();
    }

}
