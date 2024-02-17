<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Exception\LogicException;
use Traversable;

interface IFrameRevolverBuilder
{
    /**
     * @throws InvalidArgument
     * @throws LogicException
     */
    public function build(): IFrameRevolver;

    /**
     * @param Traversable<ISequenceFrame> $frames
     */
    public function withFrames(Traversable $frames): IFrameRevolverBuilder;

    public function withInterval(IInterval $interval): IFrameRevolverBuilder;

    public function withTolerance(ITolerance $tolerance): IFrameRevolverBuilder;
}
