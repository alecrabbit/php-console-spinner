<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Contract\Factory;

use AlecRabbit\Lib\Spinner\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;

interface IBenchmarkingDriverFactory extends IDriverFactory
{
    public function create(): IBenchmarkingDriver;
}
