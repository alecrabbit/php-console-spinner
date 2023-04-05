<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\StylePattern;

use AlecRabbit\Spinner\Contract\OptionStyleMode;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Pattern\StylePattern\A\AStylePattern;
use Traversable;

/** @psalm-suppress UnusedClass */
final class NoStylePattern extends AStylePattern
{
    protected const STYLE_MODE = OptionStyleMode::NONE;

    public function __construct(
    ) {
        parent::__construct();
        $this->interval = new Interval();
    }

    protected function pattern(): Traversable
    {
        yield from [
            new Frame('%s', 0),
        ];
    }
}
