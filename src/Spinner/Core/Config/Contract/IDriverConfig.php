<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Contract\Mode\LinkerMode;

interface IDriverConfig extends IConfigElement
{
    public function getLinkerMode(): LinkerMode;
}
