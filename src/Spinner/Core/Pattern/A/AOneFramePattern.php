<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Pattern\A;

use AlecRabbit\Spinner\Contract\IFrame;
use Traversable;

/** @psalm-suppress UnusedClass */
abstract class AOneFramePattern extends APattern
{
    public function __construct(
        protected IFrame $frame,
    ) {
        parent::__construct();
    }

    public function getEntries(): ?Traversable
    {
        yield from [
            $this->frame,
        ];
    }
}