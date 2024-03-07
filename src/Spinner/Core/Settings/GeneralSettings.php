<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\ExecutionModeOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IGeneralSettings;

final readonly class GeneralSettings implements IGeneralSettings
{
    public function __construct(
        private ExecutionModeOption $executionModeOption = ExecutionModeOption::AUTO,
    ) {
    }

    public function getExecutionModeOption(): ExecutionModeOption
    {
        return $this->executionModeOption;
    }

    public function getIdentifier(): string
    {
        return IGeneralSettings::class;
    }
}
