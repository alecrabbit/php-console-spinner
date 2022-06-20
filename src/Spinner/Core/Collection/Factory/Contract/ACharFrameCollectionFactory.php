<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Factory\Contract;

use AlecRabbit\Spinner\Core\Collection\CharFrameCollection;
use AlecRabbit\Spinner\Core\Collection\Contract\ICharFrameCollection;
use AlecRabbit\Spinner\Core\Frame\Factory\Contract\ICharFrameFactory;

abstract class ACharFrameCollectionFactory implements ICharFrameCollectionFactory
{
    public function __construct(
        protected readonly ICharFrameFactory $frameFactory,
    ) {
    }

    public function create(array $frames = []): ICharFrameCollection
    {
        if ([] === $frames) {
            return new CharFrameCollection([$this->frameFactory->create('0', 1)]);
        }
        return new CharFrameCollection($frames);
    }
}
