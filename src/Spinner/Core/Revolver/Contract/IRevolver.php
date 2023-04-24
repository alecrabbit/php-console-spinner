<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Contract\HasInterval;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IFrameUpdatable;

interface IRevolver extends IFrameUpdatable, HasInterval
{
    final const TOLERANCE = 5;

    public function setInterval(IInterval $interval): void;
}
