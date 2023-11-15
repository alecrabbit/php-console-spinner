<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use ArrayObject;
use Traversable;

final class DefinitionRegistry implements IDefinitionRegistry
{
    private static ?IDefinitionRegistry $instance = null;

    /** @var ArrayObject<string|int, IServiceDefinition> */
    private readonly ArrayObject $definitions;

    private function __construct(
        ArrayObject $definitions = new ArrayObject(),
    ) {
        /** @var ArrayObject<string|int, IServiceDefinition> $definitions */
        $this->definitions = $definitions;
    }

    public static function getInstance(): IDefinitionRegistry
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /** @inheritDoc */
    public function load(): Traversable
    {
        yield from $this->definitions;
    }

    /** @inheritDoc */
    public function bind(
        string|IServiceDefinition $id,
        callable|object|string $definition = null,
        int $options = 0
    ): void {
        if ($id instanceof IServiceDefinition) {
            $this->definitions->append($id);
            return;
        }
        $this->definitions->offsetSet($id, new ServiceDefinition($id, $definition, $options));
    }
}
