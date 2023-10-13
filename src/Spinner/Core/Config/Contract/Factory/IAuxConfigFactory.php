<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;

interface IAuxConfigFactory
{
    public function create(): IAuxConfig;
}
