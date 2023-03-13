<?php

declare(strict_types=1);
// 14.02.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\ILoopProbe;
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

    /**
     * @throws InvalidArgumentException
     */
    public static function addProbe(string $className): void
    {
        if (is_subclass_of($className, ILoopProbe::class)) {
            self::addLoopProbeClass($className);
            return;
        }
        if (is_subclass_of($className, ITerminalProbe::class)) {
            self::addTerminalProbeClass($className);
            return;
        }
        throw new InvalidArgumentException(
            sprintf('Class "%s" is not a probe.', $className)
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    protected static function addLoopProbeClass(string $className): void
    {
        foreach (self::$registeredLoopProbes as $probe) {
            if ($probe === $className) {
                throw new InvalidArgumentException(
                    sprintf('Loop probe class "%s" is already registered.', $className)
                );
            }
        }
        self::$registeredLoopProbes[] = $className;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected static function addTerminalProbeClass(string $className): void
    {
        foreach (self::$registeredTerminalProbes as $probe) {
            if ($probe === $className) {
                throw new InvalidArgumentException(
                    sprintf('Terminal probe class "%s" is already registered.', $className)
                );
            }
        }
        self::$registeredTerminalProbes[] = $className;
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
