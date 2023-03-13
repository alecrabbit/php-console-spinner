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

    /** @var array<class-string<ILoopProbe|ITerminalProbe>> */
    private static iterable $addedProbes = [];

    /** @var null|class-string<IDefaults> */
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
        /** @var IDefaults $c */
        $c = $className;
        foreach (self::$addedProbes as $probe) {
            $c::registerProbe($probe);
        }
     }

    /**
     * @throws InvalidArgumentException
     */
    public static function addProbe(string $className): void
    {
        Asserter::classExists($className, __METHOD__);

        foreach (self::$addedProbes as $probe) {
            if ($probe === $className) {
                throw new InvalidArgumentException(
                    sprintf('Probe class "%s" is already added.', $className)
                );
            }
        }
        self::$addedProbes[] = $className;
//        if (is_subclass_of($className, ILoopProbe::class)) {
//            self::addLoopProbeClass($className);
//            return;
//        }
//        if (is_subclass_of($className, ITerminalProbe::class)) {
//            self::addTerminalProbeClass($className);
//            return;
//        }
//        throw new InvalidArgumentException(
//            sprintf('Class "%s" is not a probe.', $className)
//        );
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
