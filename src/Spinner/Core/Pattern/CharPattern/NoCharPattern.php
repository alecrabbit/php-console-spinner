<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\CharPattern;

use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Pattern\A\APattern;
use Traversable;

/** @psalm-suppress UnusedClass */
final class NoCharPattern extends APattern
{
    public function __construct()
    {
        parent::__construct();
        $this->interval = new Interval();
    }

    protected function pattern(): Traversable
    {
        yield from [
            new Frame('', 0),
        ];
    }
}
