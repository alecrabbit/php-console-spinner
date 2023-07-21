<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IAuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Tests\Unit\Spinner\Core\Defaults\AuxSettingsTest;

final class Settings implements ISettings
{
    public function __construct(
        protected RunMethodOption $runMethodOption = RunMethodOption::AUTO,
        protected IAuxSettings $auxSettings = new AuxSettings(),
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

    public function getAuxSettings(): IAuxSettings
    {
        return $this->auxSettings;
    }
}
