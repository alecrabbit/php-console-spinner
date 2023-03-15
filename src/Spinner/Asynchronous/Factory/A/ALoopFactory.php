<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Asynchronous\Factory\A;

use AlecRabbit\Spinner\I\ILoop;
use AlecRabbit\Spinner\I\ILoopGetter;
use AlecRabbit\Spinner\I\ILoopProbe;
use AlecRabbit\Spinner\I\ILoopSignalHandlers;
use AlecRabbit\Spinner\I\ILoopSpinnerAttach;
use AlecRabbit\Spinner\Core\Factory\A\ADefaultsAwareClass;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\DefaultsFactory;
use AlecRabbit\Spinner\Mixin\NoInstanceTrait;
use DomainException;

abstract class ALoopFactory extends ADefaultsAwareClass implements ILoopFactory
{
    use NoInstanceTrait;

    protected static ?ILoop $loop = null;

    final public static function create(): ILoop|ILoopGetter|ILoopSignalHandlers|ILoopSpinnerAttach
    {
        if (static::$loop instanceof ILoop) {
            return static::$loop;
        }
        return static::createLoop();
    }

    protected static function createLoop(): ILoop|ILoopGetter|ILoopSignalHandlers|ILoopSpinnerAttach
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

    protected static function getProbeClasses(): iterable
    {
        return
            DefaultsFactory::get()->getProbeClasses();
    }
}
