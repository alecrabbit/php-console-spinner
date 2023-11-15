<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use ArrayObject;
use Traversable;

final class DefinitionRegistry implements IDefinitionRegistry
{
    private static ?IDefinitionRegistry $instance = null;

    private function __construct(
        private readonly ArrayObject $definitions = new ArrayObject(),
    ) {
    }

    public static function getInstance(): IDefinitionRegistry
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function load(): Traversable
    {
        yield from $this->definitions;
    }

    /** @inheritDoc */
    public function bind(string $id, callable|object|string $definition, int $options = 0): void
    {
//        $this->definitions->offsetSet($id, $definition);
        $this->definitions->offsetSet($id, new ServiceDefinition($id, $definition, $options));
    }
}
