<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Pattern;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Pattern\A\AOneFramePattern;

/** @psalm-suppress UnusedClass */
final class NoCharPattern extends AOneFramePattern
{
    public function __construct()
    {
        parent::__construct(new CharFrame('', 0));
    }


    public function getEntries(): ?\Traversable
    {
        yield from [
            $this->frame,
        ];
    }
}
