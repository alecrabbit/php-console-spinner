<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\FrameCollection;
use Traversable;

final class FrameCollectionFactory implements IFrameCollectionFactory
{

    /** @inheritDoc */
    public function create(Traversable $frames): IFrameCollection
    {
        return new FrameCollection($frames);
    }
}
