<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Factory\A;

use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Factory\DefaultsFactory;
use DomainException;

abstract class ALoopFactory extends ADefaultsAwareClass implements ILoopFactory
{
    protected static ?ILoop $loop = null;

    // @codeCoverageIgnoreStart
    final private function __construct()
    {
        // no instances allowed
    }

    // @codeCoverageIgnoreEnd

    final public static function create(): ILoop
    {
        if (static::$loop instanceof ILoop) {
            return static::$loop;
        }
        return static::createLoop();
    }

    protected static function createLoop(): ILoop
    {
        /** @var ILoopProbe $probe */
        foreach (static::getLoopProbesClasses() as $probe) {
            if ($probe::isSupported()) {
                return $probe::create();
            }
        }
        throw new DomainException('No supported event loop found.');
    }

    protected static function getLoopProbesClasses(): iterable
    {
        return
            DefaultsFactory::create()->getLoopProbeClasses();
    }
}
