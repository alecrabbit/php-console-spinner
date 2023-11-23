<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\Option\DriverOption;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IMessages;

final readonly class DriverSettings implements IDriverSettings
{
    public function __construct(
        private ?IMessages $messages = null,
        private DriverOption $driverOption = DriverOption::AUTO,
    ) {
    }

    public function getIdentifier(): string
    {
        return IDriverSettings::class;
    }

    public function getMessages(): ?IMessages
    {
        return $this->messages;
    }

    public function getDriverOption(): DriverOption
    {
        return $this->driverOption;
    }
}
