<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\InitializationOption;
use AlecRabbit\Spinner\Contract\Option\LinkerOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;

final class DriverSettings implements IDriverSettings
{
    public function __construct(
        protected LinkerOption $linkerOption = LinkerOption::AUTO,
        protected InitializationOption $initializationOption = InitializationOption::AUTO,
    ) {
    }

    public function getLinkerOption(): LinkerOption
    {
        return $this->linkerOption;
    }

    public function setLinkerOption(LinkerOption $linkerOption): void
    {
        $this->linkerOption = $linkerOption;
    }

    public function getInitializationOption(): InitializationOption
    {
        return $this->initializationOption;
    }

    public function setInitializationOption(InitializationOption $initializationOption): void
    {
        $this->initializationOption = $initializationOption;
    }

    public function getIdentifier(): string
    {
        return IDriverSettings::class;
    }

}
