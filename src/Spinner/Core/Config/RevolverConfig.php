<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Tolerance;

final readonly class RevolverConfig implements IRevolverConfig
{
    public function __construct(
        protected ITolerance $tolerance = new Tolerance(),
    ) {
    }

    public function getTolerance(): ITolerance
    {
        return $this->tolerance;
    }
}
