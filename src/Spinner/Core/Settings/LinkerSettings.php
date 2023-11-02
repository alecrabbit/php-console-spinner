<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\LinkerOption;
use AlecRabbit\Spinner\Core\Settings\Contract\ILinkerSettings;

final class LinkerSettings implements ILinkerSettings
{
    public function __construct(
        protected LinkerOption $linkerOption = LinkerOption::AUTO,
    ) {
    }

    public function getLinkerOption(): LinkerOption
    {
        return $this->linkerOption;
    }

    public function getIdentifier(): string
    {
        return ILinkerSettings::class;
    }

}
