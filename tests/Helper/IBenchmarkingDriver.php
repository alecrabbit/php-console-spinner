<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Helper;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Tests\Helper\Contract\IStopwatch;

interface IBenchmarkingDriver extends IDriver
{
    public function getStopwatch(): IStopwatch;
}
