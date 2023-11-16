<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Settings\Contract\IOutputSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\InvalidArgument;

final readonly class StreamSolver extends ASolver implements Contract\IStreamSolver
{
    public function solve(): mixed
    {
        return
            $this->doSolve(
                $this->extractStream($this->settingsProvider->getUserSettings()),
                $this->extractStream($this->settingsProvider->getDetectedSettings()),
                $this->extractStream($this->settingsProvider->getDefaultSettings()),
            );
    }

    private function doSolve(
        mixed $userStream,
        mixed $detectedStream,
        mixed $defaultStream
    ): mixed {
        return
            $userStream
            ?? $detectedStream
            ?? $defaultStream
            ?? throw new InvalidArgument(
                'Unable to solve "stream".'
            );
    }

    protected function extractStream(ISettings $settings): mixed
    {
        return $this->extractSettingsElement($settings, IOutputSettings::class)?->getStream();
    }
}
