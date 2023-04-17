<?php

declare(strict_types=1);

// 12.04.23
namespace AlecRabbit\Spinner\Core\Revolver;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Exception\LogicException;

final class FrameRevolverBuilder implements IFrameRevolverBuilder
{
    protected ?IFrameCollection $frames = null;
    protected ?IInterval $interval = null;

    public function build(): IFrameRevolver
    {
        $this->validate();

        return
            new FrameCollectionRevolver(
                $this->frames,
                $this->interval
            );
    }

    protected function validate(): void
    {
        match (true) {
            null === $this->frames => throw new LogicException('Frames are not set.'),
            null === $this->interval => throw new LogicException('Interval is not set.'),
            default => null,
        };
    }

    public function withFrames(IFrameCollection $frames): IFrameRevolverBuilder
    {
        $clone = clone $this;
        $clone->frames = $frames;
        return $clone;
    }

    public function withInterval(IInterval $interval): IFrameRevolverBuilder
    {
        $clone = clone $this;
        $clone->interval = $interval;
        return $clone;
    }
}
