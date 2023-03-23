<?php

declare(strict_types=1);
// 16.03.23
namespace AlecRabbit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Core\AnsiColorConverter;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Factory\Contract\IRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalFactory;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Core\NativeColorConverter;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use ArrayObject;

abstract class ARevolverFactory extends ADefaultsAwareClass implements IRevolverFactory
{
    private static ?IFrameRevolverBuilder $revolverBuilder = null;

    public static function defaultStyleRevolver(): IRevolver
    {
        return
            new FrameCollectionRevolver(
                new FrameCollection(
                    new ArrayObject([
                        FrameFactory::create('%s', 0),
                    ])
                ),
                IntervalFactory::createStill()
            );
    }

    public static function create(IPattern $pattern): IRevolver
    {
        return self::getRevolverBuilder()->withPattern($pattern)->build();
    }

    public static function getRevolverBuilder(?IDefaults $defaults = null): IFrameRevolverBuilder
    {
        if (null === static::$revolverBuilder) {
            static::$revolverBuilder = self::createRevolverBuilder($defaults);
        }
        return static::$revolverBuilder;
    }

    protected static function createRevolverBuilder(?IDefaults $defaults): IFrameRevolverBuilder
    {
        $defaults ??= static::getDefaults();

        $revolverBuilderClass = $defaults->getClasses()->getFrameRevolverBuilderClass();

        return
            new $revolverBuilderClass(static::getDefaults(), new AnsiColorConverter());
    }

    public static function defaultCharRevolver(): IRevolver
    {
        return
            new FrameCollectionRevolver(
                new FrameCollection(
                    new ArrayObject([
                        FrameFactory::createEmpty(),
                    ])
                ),
                IntervalFactory::createStill()
            );
    }
}