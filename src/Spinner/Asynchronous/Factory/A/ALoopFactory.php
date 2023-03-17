<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Factory\A;

use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Core\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Factory\A\ADefaultsAwareClass;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\DefaultsFactory;
use AlecRabbit\Spinner\Mixin\NoInstanceTrait;
use DomainException;

abstract class ALoopFactory extends ADefaultsAwareClass implements ILoopFactory
{
    use NoInstanceTrait;

    protected static ?ILoopAdapter $loop = null;

    final public static function create(): ILoopAdapter
    {
        if (static::$loop instanceof ILoopAdapter) {
            return static::$loop;
        }
        return static::createLoop();
    }

    protected static function createLoop(): ILoopAdapter
    {
        foreach (static::getProbeClasses() as $probe) {
            if (is_subclass_of($probe, ILoopProbe::class) && $probe::isSupported()) {
                return $probe::createLoop();
            }
        }
        throw new DomainException(
            'No supported event loop found.' .
            ' Check you have installed one of the supported event loops.' .
            ' Check your probes list if you have modified it.'
        );
    }

    protected static function getProbeClasses(): \Traversable
    {
        return
            DefaultsFactory::get()->getProbeClasses();
    }
}
