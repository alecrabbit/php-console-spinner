<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Factory\Contract;

use AlecRabbit\Spinner\Core\Collection\CharFrameCollection;
use AlecRabbit\Spinner\Core\Collection\Contract\ICharFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ICharProvider;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Interval\Interval;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\RuntimeException;

abstract class ACharFrameCollectionFactory implements ICharFrameCollectionFactory
{
    public function __construct(
        protected readonly ICharProvider $charProvider,
    ) {
    }

    /**
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public function create(array $frames, ?IInterval $interval): ICharFrameCollection
    {
        if ([] === $frames) {
            return $this->defaultCollection();
        }
        return new CharFrameCollection($frames, $interval ?? new Interval(null));
    }

    /**
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    private function defaultCollection(): ICharFrameCollection
    {
        return
            new CharFrameCollection(
                ...$this->charProvider->provide()
            );
    }
}
