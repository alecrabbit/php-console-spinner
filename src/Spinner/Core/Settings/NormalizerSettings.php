<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\INormalizerSettings;

final readonly class NormalizerSettings implements INormalizerSettings
{
    public function __construct(
        protected NormalizerOption $normalizerOption = NormalizerOption::AUTO,
    ) {
    }

    public function getNormalizerOption(): NormalizerOption
    {
        return $this->normalizerOption;
    }

    public function getIdentifier(): string
    {
        return INormalizerSettings::class;
    }
}
