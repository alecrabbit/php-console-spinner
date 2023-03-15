<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Asynchronous\Factory\A;

use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\ILoopGetter;
use AlecRabbit\Spinner\Core\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Contract\ILoopSignalHandlers;
use AlecRabbit\Spinner\Core\Contract\ISpinnerAttacher;
use AlecRabbit\Spinner\Core\Factory\A\ADefaultsAwareClass;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\DefaultsFactory;
use AlecRabbit\Spinner\Mixin\NoInstanceTrait;
use DomainException;

abstract class ALoopFactory extends ADefaultsAwareClass implements ILoopFactory
{
    use NoInstanceTrait;

    protected static ?ILoop $loop = null;

    final public static function create(): ILoop|ILoopGetter|ILoopSignalHandlers|ISpinnerAttacher
    {
        if (static::$loop instanceof ILoop) {
            return static::$loop;
        }
        return static::createLoop();
    }

    protected static function createLoop(): ILoop|ILoopGetter|ILoopSignalHandlers|ISpinnerAttacher
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
