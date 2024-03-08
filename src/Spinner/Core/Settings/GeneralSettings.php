<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\ExecutionOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IGeneralSettings;

final readonly class GeneralSettings implements IGeneralSettings
{
    public function __construct(
        private ExecutionOption $executionOption = ExecutionOption::AUTO,
    ) {
    }

    public function getExecutionOption(): ExecutionOption
    {
        return $this->executionOption;
    }

    public function getIdentifier(): string
    {
        return IGeneralSettings::class;
    }
}
