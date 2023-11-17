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

    /** @var ArrayObject<string, IServiceDefinition> */
    private readonly ArrayObject $definitions;

    private function __construct(
        ArrayObject $definitions = new ArrayObject(),
    ) {
        /** @var ArrayObject<string, IServiceDefinition> $definitions */
        $this->definitions = $definitions;
    }

    public static function getInstance(): IDefinitionRegistry
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /** @inheritDoc */
    public function load(): Traversable
    {
        yield from $this->definitions;
    }


    public function bind(IServiceDefinition $serviceDefinition): void
    {
        $this->definitions->offsetSet($serviceDefinition->getId(), $serviceDefinition);
    }
}
