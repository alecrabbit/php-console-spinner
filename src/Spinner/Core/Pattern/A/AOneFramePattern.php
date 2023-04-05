<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Interval;
use Traversable;

/** @psalm-suppress UnusedClass */
abstract class AOneFramePattern extends APattern
{
    public function __construct(
        protected IFrame $frame,
    )
    {
        parent::__construct();
        $this->interval = new Interval();
    }

    protected function pattern(): Traversable
    {
        yield from [
            $this->frame,
        ];
    }
}
