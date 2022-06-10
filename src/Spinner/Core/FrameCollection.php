<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\Base\Defaults;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Rotor\Interval;
use ArrayIterator;
use Traversable;

final class FrameCollection implements IFrameCollection
{
    /** @var array<int, IFrame> */
    private array $frames = [];
    private int $count = 0;
    private IInterval $interval;

    protected function __construct(?int $interval = null)
    {
        $seconds = ($interval ?? Defaults::MILLISECONDS_INTERVAL) / 1000;
        $this->interval = new Interval($seconds);
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function create(iterable|string $frames, ?int $elementWidth = null, ?int $interval = null): self
    {
        if (is_string($frames)) {
            $frames = StrSplitter::split($frames);
        }

        $f = new self($interval);
        foreach ($frames as $element) {
            if ($element instanceof IFrame) {
                $f->add($element);
                continue;
            }
            $f->add(Frame::create($element, $elementWidth));
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

    public function getInterval(): IInterval
    {
        return $this->interval;
    }
}
