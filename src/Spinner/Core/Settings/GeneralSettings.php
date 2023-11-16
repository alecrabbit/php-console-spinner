<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IGeneralSettings;

final readonly class GeneralSettings implements IGeneralSettings
{
    public function __construct(
        protected RunMethodOption $runMethodOption = RunMethodOption::AUTO,
    ) {
    }

    public function getRunMethodOption(): RunMethodOption
    {
        return $this->runMethodOption;
    }

    public function getIdentifier(): string
    {
        return IGeneralSettings::class;
    }
}
