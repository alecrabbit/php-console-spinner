<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Factory\Contract;

use AlecRabbit\Spinner\Core\Collection\Contract\IStyleFrameCollection;
use AlecRabbit\Spinner\Core\Collection\StyleFrameCollection;
use AlecRabbit\Spinner\Core\Contract\IStyleProvider;
use AlecRabbit\Spinner\Core\Defaults;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Interval\Interval;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\RuntimeException;

abstract class AStyleFrameCollectionFactory implements IStyleFrameCollectionFactory
{
    public function __construct(
        protected readonly IStyleProvider $styleProvider,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function create(array $frames, ?IInterval $interval): IStyleFrameCollection
    {
        if ([] === $frames) {
            return $this->defaultCollection();
        }
        return StyleFrameCollection::create($frames, $interval ?? new Interval(null));
    }

    /**
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    private function defaultCollection(): IStyleFrameCollection
    {
        return
            StyleFrameCollection::create(
                ...$this->styleProvider->provide(Defaults::getDefaultStyle())
            );
    }
}
