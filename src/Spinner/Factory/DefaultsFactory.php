<?php

declare(strict_types=1);
// 14.02.23
namespace AlecRabbit\Spinner\Factory;

use AlecRabbit\Spinner\Config\Defaults\A\ADefaults;
use AlecRabbit\Spinner\Config\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Helper\Asserter;
use AlecRabbit\Spinner\Mixin\NoInstanceTrait;

final class DefaultsFactory
{
    use NoInstanceTrait;

    /** @var null|class-string */
    private static ?string $className = null;

    public static function create(): IDefaults
    {
        if (null === self::$className) {
            self::$className = ADefaults::class;
        }
        /** @noinspection PhpUndefinedMethodInspection */
        return self::$className::getInstance();
    }

    /**
     * @throws InvalidArgumentException
     * @throws DomainException
     */
    public static function setDefaultsClass(string $class): void
    {
        Asserter::isSubClass($class, IDefaults::class, __METHOD__);

        if (null !== self::$className) {
            throw new DomainException(
                'Defaults class can be set only once - before first defaults instance is created.'
            );
        }

        self::$className = $class;
    }
}
