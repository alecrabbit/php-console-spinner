<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Contract\Option\DriverOption;

interface IDriverSettings extends ISettingsElement
{
    public function getMessages(): ?IMessages;

    public function getDriverOption(): DriverOption;
}
