<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;

interface ILoopConfigFactory
{
    public function create(): ILoopConfig;
}
