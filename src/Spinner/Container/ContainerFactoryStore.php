<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IContainerFactory;
use AlecRabbit\Spinner\Container\Contract\IContainerFactoryStore;
use Traversable;

final class ContainerFactoryStore implements IContainerFactoryStore
{
    public function __construct(
        private \ArrayObject $factories = new \ArrayObject(),
    ) {
    }

    public function add(IContainerFactory $factory): void
    {
        $this->factories->append($factory);
    }

    /** @inheritDoc */
    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->reversed());
    }

    private function reversed(): array
    {
        return \array_reverse($this->factories->getArrayCopy());
    }
}
