<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Factory\Contract;

use AlecRabbit\Spinner\Core\Collection\CharFrameCollection;
use AlecRabbit\Spinner\Core\Collection\Contract\ICharFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ICharProvider;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

abstract class ACharFrameCollectionFactory implements ICharFrameCollectionFactory
{
    public function __construct(
        protected readonly ICharProvider $charProvider,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function create(?array $charPattern = null): ICharFrameCollection
    {
        return
            CharFrameCollection::create(
                ...$this->charProvider->provide($charPattern)
            );
    }
}
