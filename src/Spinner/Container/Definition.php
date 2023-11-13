<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IDefinition;
use AlecRabbit\Spinner\Exception\InvalidArgument;

final readonly class Definition implements IDefinition
{
    protected string $id;
    /** @var object|callable|string */
    protected mixed $definition;
    protected int $options;

    public function __construct(
        string $id,
        mixed $definition,
        int $options = self::SINGLETON,
    ) {
        self::assertDefinition($definition);
        self::assertOptions($options);

        $this->id = $id;
        /** @var object|callable|string $definition */
        $this->definition = $definition;
        $this->options = $options;
    }

    private static function assertDefinition(mixed $definition): void
    {
        if (!is_callable($definition) && !is_object($definition) && !is_string($definition)) {
            throw new InvalidArgument(
                sprintf(
                    'Definition should be callable, object or string, "%s" given.',
                    get_debug_type($definition),
                )
            );
        }
    }

    private static function assertOptions(int $options): void
    {
        if ($options < 0) {
            throw new InvalidArgument(
                sprintf('Invalid options. Negative value: [%s].', $options)
            );
        }

        $maxValue = self::maxOptionsValue();

        if ($options > $maxValue) {
            throw new InvalidArgument(
                sprintf('Invalid options. Max value exceeded: [%s].', $maxValue)
            );
        }
    }

    private static function maxOptionsValue(): int
    {
        return
            self::SINGLETON
            | self::TRANSIENT;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDefinition(): object|callable|string
    {
        return $this->definition;
    }

    public function getOptions(): int
    {
        return $this->options;
    }
}
