<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Contract\HasInterval;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IUpdatable;

interface IRevolver extends IUpdatable, HasInterval
{
    public function setInterval(IInterval $interval): void;
}
