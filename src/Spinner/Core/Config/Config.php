<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;

final class Config implements Contract\IConfig
{
    public function __construct(
        protected IAuxConfig $auxConfig,
    ) {
    }

    public function getAuxConfig(): IAuxConfig
    {
        return $this->auxConfig;
    }
}
