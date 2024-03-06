<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\IReference;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\Exception\InvalidDefinitionArgument;
use AlecRabbit\Spinner\Container\Exception\InvalidOptionsArgument;

final readonly class ServiceDefinition implements IServiceDefinition
{
    private string $id;
    /** @var IReference|class-string */
    private IReference|string $definition;
    private int $options;

    public function __construct(
        string $id,
        IReference|string $definition,
        int $options = self::DEFAULT,
    ) {
        self::assertOptions($options);

        $this->id = $id;
        /** @var IReference|class-string $definition */
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

    public function getId(): string
    {
        return $this->id;
    }

    public function getDefinition(): object|string
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
