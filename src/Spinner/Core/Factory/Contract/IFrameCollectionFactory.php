<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use Traversable;

interface IFrameCollectionFactory
{
    /**
     * @param Traversable<IFrame> $frames
     *
     * @throws InvalidArgument
     */
    public function create(Traversable $frames): IFrameCollection;
}
