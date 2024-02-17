<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Exception\LogicException;
use Traversable;

interface IFrameCollectionRevolverBuilder extends IFrameRevolverBuilder
{
    /**
     * @throws InvalidArgument
     * @throws LogicException
     */
    public function build(): IFrameCollectionRevolver;

    /**
     * @param IFrameCollection|Traversable<ISequenceFrame> $frames
     * @return IFrameCollectionRevolverBuilder
     * @throws InvalidArgument
     */
    public function withFrames(IFrameCollection|Traversable $frames): IFrameCollectionRevolverBuilder;

    public function withInterval(IInterval $interval): IFrameCollectionRevolverBuilder;

    public function withTolerance(ITolerance $tolerance): IFrameCollectionRevolverBuilder;
}
