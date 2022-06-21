<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Factory\Contract;

use AlecRabbit\Spinner\Core\Collection\Contract\IStyleFrameCollection;
use AlecRabbit\Spinner\Core\Collection\StyleFrameCollection;
use AlecRabbit\Spinner\Core\Frame\Factory\Contract\IStyleFrameFactory;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\RuntimeException;

abstract class AStyleFrameCollectionFactory implements IStyleFrameCollectionFactory
{
    public function __construct(
        protected readonly IStyleFrameFactory $frameFactory,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function create(array $frames = null): IStyleFrameCollection
    {
        if(null === $frames) {
            return $this->defaultCollection();
        }
        return new StyleFrameCollection($frames);
    }

    /**
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    private function defaultCollection(): IStyleFrameCollection
    {
        return new StyleFrameCollection([$this->frameFactory->create()]);
    }
}
