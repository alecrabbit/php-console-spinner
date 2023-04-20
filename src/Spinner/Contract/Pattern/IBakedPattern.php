<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Contract\Pattern;

use AlecRabbit\Spinner\Contract\IInterval;
use Traversable;

interface IBakedPattern
{
    public function getFrames(): Traversable;

    public function getInterval(): IInterval;
}
