<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use Traversable;

final class DefinitionRegistry implements IDefinitionRegistry
{
    private static ?IDefinitionRegistry $instance = null;
    private array $definitions = [];

    private function __construct()
    {
        // Enforcing singleton
    }

    public static function getInstance(): IDefinitionRegistry
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getDefinitions(): Traversable
    {
        yield from $this->definitions;
    }

    public function register(string $typeId, callable|object|string $definition): void
    {
        $this->definitions[$typeId] = $definition;
    }
}
