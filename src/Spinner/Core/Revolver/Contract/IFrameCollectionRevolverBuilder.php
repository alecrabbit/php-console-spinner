<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Exception\LogicException;

interface IFrameCollectionRevolverBuilder
{
    /**
     * @throws InvalidArgument
     * @throws LogicException
     */
    public function build(): IFrameRevolver;

    public function withFrameCollection(IFrameCollection $frames): IFrameCollectionRevolverBuilder;

    public function withInterval(IInterval $interval): IFrameCollectionRevolverBuilder;

    public function withTolerance(ITolerance $tolerance): IFrameCollectionRevolverBuilder;
}
