<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\Mode\ExecutionMode;

interface IGeneralConfig extends IConfigElement
{
    public function getExecutionMode(): ExecutionMode;
}
