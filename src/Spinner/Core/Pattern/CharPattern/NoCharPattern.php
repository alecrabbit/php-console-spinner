<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\CharPattern;

use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Pattern\A\AOneFramePattern;
use Traversable;

/** @psalm-suppress UnusedClass */
final class NoCharPattern extends AOneFramePattern
{
    public function __construct()
    {
        parent::__construct(new Frame('', 0));

    }

}
