<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory\Config;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;

interface IConfigFactory
{
    public function create(): IConfig;
}
