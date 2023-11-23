<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Settings\Contract\IRevolverSettings;

final readonly class RevolverSettings implements IRevolverSettings
{
    public function __construct(
        private ITolerance $tolerance,
    ) {
    }

    public function getTolerance(): ?ITolerance
    {
        return $this->tolerance;
    }

    public function getIdentifier(): string
    {
        return IRevolverSettings::class;
    }
}
