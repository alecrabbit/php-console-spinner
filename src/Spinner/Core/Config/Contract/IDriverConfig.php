<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\Mode\DriverMode;
use AlecRabbit\Spinner\Core\Contract\IDriverMessages;

interface IDriverConfig extends IConfigElement
{
    public function getDriverMessages(): IDriverMessages;

    public function getDriverMode(): DriverMode;
}
