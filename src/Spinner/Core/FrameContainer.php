<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IFrameContainer;
use ArrayIterator;
use IteratorAggregate;
use Traversable;

final class FrameContainer implements IFrameContainer, IteratorAggregate
{
    /** @var array<int, IFrame> */
    private array $frames = [];
    private int $count = 0;

    public function __construct(iterable $frames)
    {
        foreach ($frames as $frame) {
            if ($frame instanceof IFrame) {
                $this->add($frame);
            }
        }
    }

    private function add(IFrame $frame): void
    {
        $this->frames[] = $frame;
        $this->count++;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->frames);
    }
}
