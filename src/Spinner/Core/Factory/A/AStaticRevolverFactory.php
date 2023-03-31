<?php

declare(strict_types=1);
// 16.03.23
namespace AlecRabbit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Contract\IAnsiStyleConverter;
use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Factory\Contract\IStaticRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\StaticAnsiColorConverterFactory;
use AlecRabbit\Spinner\Core\Factory\StaticFrameFactory;
use AlecRabbit\Spinner\Core\Factory\StaticIntervalFactory;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use ArrayObject;

abstract class AStaticRevolverFactory extends ADefaultsAwareClass implements IStaticRevolverFactory
{
    private static ?IFrameRevolverBuilder $revolverBuilder = null;

    public static function defaultStyleRevolver(): IRevolver
    {
        return
            new FrameCollectionRevolver(
                new FrameCollection(
                    new ArrayObject([
                        StaticFrameFactory::create('%s', 0),
                    ])
                ),
                StaticIntervalFactory::createStill()
            );
    }

    public static function create(IPattern $pattern, ?IDefaults $defaults = null): IRevolver
    {
        return self::getRevolverBuilder($defaults)->withPattern($pattern)->build();
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
            new $revolverBuilderClass(static::getDefaults(), self::getColorConverter($defaults));
    }

    protected static function getColorConverter(?IDefaults $defaults): IAnsiStyleConverter
    {
        return StaticAnsiColorConverterFactory::getGetAnsiColorConverter($defaults);
    }

    public static function defaultCharRevolver(): IRevolver
    {
        return
            new FrameCollectionRevolver(
                new FrameCollection(
                    new ArrayObject([
                        StaticFrameFactory::createEmpty(),
                    ])
                ),
                StaticIntervalFactory::createStill()
            );
    }
}
