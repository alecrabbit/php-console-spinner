<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;

final class AuxSettings implements IAuxSettings
{
    public function __construct(
        protected RunMethodOption $runMethodOption = RunMethodOption::AUTO,
        protected NormalizerOption $normalizerOption = NormalizerOption::AUTO,
    ) {
    }

    public function getRunMethodOption(): RunMethodOption
    {
        return $this->runMethodOption;
    }

    public function getNormalizerOption(): NormalizerOption
    {
        return $this->normalizerOption;
    }

    public function getIdentifier(): string
    {
        return IAuxSettings::class;
    }
}
