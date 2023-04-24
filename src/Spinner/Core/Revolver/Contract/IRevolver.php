<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\IFrameUpdatable;
use AlecRabbit\Spinner\Contract\IInterval;

interface IRevolver extends IFrameUpdatable, IHasInterval
{
    final const TOLERANCE = 5;

    public function setInterval(IInterval $interval): void;
}
