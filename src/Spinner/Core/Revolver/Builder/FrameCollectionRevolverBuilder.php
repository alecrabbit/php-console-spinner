<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\Builder;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Exception\LogicException;
use Traversable;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class FrameCollectionRevolverBuilder implements IFrameCollectionRevolverBuilder
{
    private ?IFrameCollection $frames = null;
    private ?IInterval $interval = null;
    private ?ITolerance $tolerance = null;

    public function build(): IFrameCollectionRevolver
    {
        $this->validate();

        return new FrameCollectionRevolver(
            $this->frames,
            $this->interval,
            $this->tolerance,
        );
    }

    /**
     * @throws LogicException
     */
    private function validate(): void
    {
        match (true) {
            $this->frames === null => throw new LogicException('Frame collection is not set.'),
            $this->interval === null => throw new LogicException('Interval is not set.'),
            $this->tolerance === null => throw new LogicException('Tolerance is not set.'),
            default => null,
        };
    }

    /** @inheritDoc */

    public function withFrames(IFrameCollection|Traversable $frames): IFrameCollectionRevolverBuilder
    {
        $this->assertFrames($frames);
        $clone = clone $this;
        $clone->frames = $frames;
        return $clone;
    }

    /**
     * @throws InvalidArgument
     */
    private function assertFrames(mixed $frames): void
    {
        if (!$frames instanceof IFrameCollection) {
            throw new InvalidArgument(
                sprintf(
                    'Frames must be instance of "%s". "%s" given.',
                    IFrameCollection::class,
                    get_debug_type($frames),
                )
            );
        }
    }

    public function withInterval(IInterval $interval): IFrameCollectionRevolverBuilder
    {
        $clone = clone $this;
        $clone->interval = $interval;
        return $clone;
    }

    public function withTolerance(ITolerance $tolerance): IFrameCollectionRevolverBuilder
    {
        $clone = clone $this;
        $clone->tolerance = $tolerance;
        return $clone;
    }
}
