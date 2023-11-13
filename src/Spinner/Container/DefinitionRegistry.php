<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use Traversable;

final class DefinitionRegistry implements IDefinitionRegistry
{
    private static ?IDefinitionRegistry $instance = null;
    private array $definitions = [];

    private function __construct()
    {
        // Can be instantiated only by getInstance()
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
    public function bind(string $id, callable|object|string $definition, ?int $options = 0): void
    {
        $this->definitions[$id] = $definition;
    }
}
