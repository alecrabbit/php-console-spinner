<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Contract\IWFrameCollection;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Rotor\Interval;
use ArrayIterator;
use Traversable;

final class WFrameCollection implements IWFrameCollection
{
    /** @var array<int, ICharFrame> */
    private array $elements = [];
    private int $count = 0;

    protected function __construct(
        private readonly IInterval $interval
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function create(iterable|string $frames, ?int $elementWidth = null, ?int $interval = null): self
    {
        if (is_string($frames)) {
            $frames = StrSplitter::split($frames);
        }

        $collection = new self(new Interval($interval));
        foreach ($frames as $element) {
            if ($element instanceof ICharFrame) {
                $collection->add($element);
                continue;
            }
            $collection->add(CharFrame::create($element, $elementWidth));
        }
        return $collection;
    }

    public function add(ICharFrame $frame): void
    {
        $this->count++;
        $this->elements[] = $frame;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->elements);
    }

    public function toArray(): array
    {
        return $this->elements;
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }
}
