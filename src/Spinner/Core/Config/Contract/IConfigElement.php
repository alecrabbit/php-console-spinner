<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Core\Config\OutputConfig;

interface IConfigElement
{
    /**
     * @return class-string<IConfigElement>
     */
    public function getIdentifier(): string;
}
