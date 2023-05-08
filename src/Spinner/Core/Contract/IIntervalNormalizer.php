<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IInterval;

interface IIntervalNormalizer
{
    public function normalize(IInterval $interval): IInterval;
}
