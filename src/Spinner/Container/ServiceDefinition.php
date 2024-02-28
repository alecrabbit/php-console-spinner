<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\Exception\InvalidDefinitionArgument;
use AlecRabbit\Spinner\Container\Exception\InvalidOptionsArgument;

final readonly class ServiceDefinition implements IServiceDefinition
{
    private string $id;
    /** @var object|callable|class-string */
    private mixed $definition;
    private int $options;

    public function __construct(
        string $id,
        mixed $definition,
        int $options = self::DEFAULT,
    ) {
        self::assertOptions($options);
        self::assertDefinition($definition);

        $this->id = $id;
        /** @var object|callable|class-string $definition */
        $this->definition = $definition;
        $this->options = $options;
    }

    private static function assertOptions(int $options): void
    {
        if ($options < 0) {
            throw new InvalidOptionsArgument(
                sprintf('Invalid options. Negative value: [%s].', $options)
            );
        }

        $maxValue = self::maxOptionsValue();

        if ($options > $maxValue) {
            throw new InvalidOptionsArgument(
                sprintf('Invalid options. Max value exceeded: [%s].', $maxValue)
            );
        }
    }

    private static function maxOptionsValue(): int
    {
        return self::SINGLETON
            | self::PUBLIC;
    }

    private static function assertDefinition(mixed $definition): void
    {
        if (!is_callable($definition) && !is_object($definition) && !is_string($definition)) {
            throw new InvalidDefinitionArgument(
                sprintf(
                    'Definition should be callable, object or string, "%s" given.',
                    get_debug_type($definition),
                )
            );
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDefinition(): object|callable|string
    {
        return $this->definition;
    }

    public function isSingleton(): bool
    {
        return ($this->options & self::SINGLETON) === self::SINGLETON;
    }

    public function isPublic(): bool
    {
        return ($this->options & self::PUBLIC) === self::PUBLIC;
    }
}
