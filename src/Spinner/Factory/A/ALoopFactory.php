<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Factory\A;

use AlecRabbit\Spinner\Asynchronous\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Asynchronous\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Factory\DefaultsFactory;
use AlecRabbit\Spinner\Mixin\NoInstanceTrait;
use DomainException;

abstract class ALoopFactory extends ADefaultsAwareClass implements ILoopFactory
{
    use NoInstanceTrait;

    protected static ?ILoop $loop = null;

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
                return $probe::createLoop();
            }
        }
        throw new DomainException(
            'No supported event loop found.' .
            ' Check you have installed one of the supported event loops.' .
            ' Check your probes list if you have modified it.'
        );
    }

    protected static function getLoopProbesClasses(): iterable
    {
        return
            DefaultsFactory::create()->getLoopProbeClasses();
    }
}
