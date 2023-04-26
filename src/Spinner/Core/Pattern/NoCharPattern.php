<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern;

use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Pattern\A\AOneFramePattern;

/** @psalm-suppress UnusedClass */
final class NoCharPattern extends AOneFramePattern
{
    public function __construct()
    {
        parent::__construct(new Frame('', 0));
    }
}
