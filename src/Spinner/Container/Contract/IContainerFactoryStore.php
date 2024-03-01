<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

interface IContainerFactoryStore extends \IteratorAggregate
{
    public function add(IContainerFactory $factory): void;

    /**
     * @return \Traversable<IContainerFactory>
     */
    public function getIterator(): \Traversable;
}
