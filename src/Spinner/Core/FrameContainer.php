<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IFrameContainer;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use ArrayIterator;
use Traversable;

final class FrameContainer implements IFrameContainer
{
    /** @var array<int, IFrame> */
    private array $frames = [];
    private int $count = 0;

    /**
     * @throws InvalidArgumentException
     */
    public static function create(iterable $frames): self
    {
        $f = new self();
        foreach ($frames as $element) {
            if ($element instanceof IFrame) {
                $f->add($element);
                continue;
            }
            $f->add(Frame::create($element));
        }
        return $f;
    }

    public function add(IFrame $frame): void
    {
        $this->count++;
        $this->frames[] = $frame;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->frames);
    }

    public function toArray(): array
    {
        return $this->frames;
    }
}
