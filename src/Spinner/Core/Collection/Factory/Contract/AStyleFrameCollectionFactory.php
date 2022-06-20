<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Factory\Contract;

use AlecRabbit\Spinner\Core\Collection\Contract\IStyleFrameCollection;
use AlecRabbit\Spinner\Core\Collection\StyleFrameCollection;
use AlecRabbit\Spinner\Core\Frame\Factory\Contract\IStyleFrameFactory;

abstract class AStyleFrameCollectionFactory implements IStyleFrameCollectionFactory
{
    public function __construct(
        protected readonly IStyleFrameFactory $frameFactory,
    ) {
    }

    public function create(array $frames = []): IStyleFrameCollection
    {
        if([] === $frames) {
            return new StyleFrameCollection([$this->frameFactory->create()]);
        }
        return new StyleFrameCollection($frames);
    }
}
