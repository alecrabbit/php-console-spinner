<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\RunMethodOption;

final class AuxSettings implements Contract\IAuxSettings
{
    public function __construct(
        protected RunMethodOption $runMethodOption = RunMethodOption::AUTO,
    ) {
    }

    public function getRunMethodOption(): RunMethodOption
    {
        return $this->runMethodOption;
    }

    public function setRunMethodOption(RunMethodOption $runMethodOption): void
    {
        $this->runMethodOption = $runMethodOption;
    }

}
