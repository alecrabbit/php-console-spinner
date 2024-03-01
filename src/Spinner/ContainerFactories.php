<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Container\Contract\IContainerFactory;
use AlecRabbit\Spinner\Exception\InvalidArgument;

final class ContainerFactories
{
    /**
     * @var array<string, class-string<IContainerFactory>>
     */
    private static array $factories = [];

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // No instances of this class are allowed.
    }

    /**
     * @param array<class-string<IContainerFactory>> $classes
     *
     * @throws InvalidArgument
     */
    public static function register(string ...$classes): void
    {
        foreach ($classes as $factoryClass) {
            self::assertClass($factoryClass);
            self::$factories[$factoryClass] = $factoryClass;
        }
    }

    private static function assertClass(string $factoryClass)
    {
        if (!self::isFactorySubclass($factoryClass)) {
            throw new InvalidArgument(
                sprintf(
                    'Class "%s" must implement "%s".',
                    $factoryClass,
                    IContainerFactory::class
                )
            );
        }
    }

    private static function isFactorySubclass(string $factoryClass): bool
    {
        return is_subclass_of($factoryClass, IContainerFactory::class);
    }

    public static function load(): array
    {
        return self::$factories;
    }
}
