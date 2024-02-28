<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use Traversable;

interface IFrameCollectionFactory
{
    /**
     * @param Traversable<ISequenceFrame> $frames
     *
     * @throws InvalidArgument
     */
    public function create(Traversable $frames): IFrameCollection;
}
