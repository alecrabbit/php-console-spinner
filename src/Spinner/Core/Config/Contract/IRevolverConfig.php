<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Core\Contract\ITolerance;

interface IRevolverConfig
{
    public function getTolerance(): ITolerance;
}
