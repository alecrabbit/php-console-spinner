<?php

declare(strict_types=1);
// 14.02.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Defaults\A\ADefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Helper\Asserter;
use AlecRabbit\Spinner\Mixin\NoInstanceTrait;

final class DefaultsFactory
{
    use NoInstanceTrait;

    private static iterable $registeredLoopProbes = [];
    private static iterable $registeredTerminalProbes = [];

    /** @var null|class-string */
    private static ?string $className = null;

    public static function create(): IDefaults
    {
        if (null === self::$className) {
            self::$className = ADefaults::class;
            self::initDefaults(self::$className);
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

    /**
     * @throws InvalidArgumentException
     */
    public static function registerLoopProbeClass(string $class): void
    {
        self::$registeredLoopProbes[] = $class;
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function registerTerminalProbeClass(string $class): void
    {
        self::$registeredTerminalProbes[] = $class;
    }

    private static function initDefaults(string $className): void
    {
        foreach (self::$registeredLoopProbes as $probe) {
            /** @noinspection PhpUndefinedMethodInspection */
            $className::registerLoopProbeClass($probe);
        }
        foreach (self::$registeredTerminalProbes as $probe) {
            /** @noinspection PhpUndefinedMethodInspection */
            $className::registerTerminalProbeClass($probe);
        }
    }
}
