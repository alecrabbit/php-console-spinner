<?php

declare(strict_types=1);
// 16.03.23
namespace AlecRabbit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Factory\Contract\IRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalFactory;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use AlecRabbit\Spinner\Exception\DomainException;
use ArrayObject;

abstract class ARevolverFactory extends ADefaultsAwareClass implements IRevolverFactory
{
    private static ?IRevolverBuilder $revolverBuilder = null;

    public static function getRevolverBuilder(IDefaults $defaults): IRevolverBuilder
    {
        if (null === static::$revolverBuilder) {
            static::$revolverBuilder = self::createRevolverBuilder($defaults);
        }
        return static::$revolverBuilder;
    }

    protected static function createRevolverBuilder(?IDefaults $defaults): IRevolverBuilder
    {
        $defaults ??= static::getDefaults();

        $revolverBuilderClass = $defaults->getClasses()->getRevolverBuilderClass();

        return
            new $revolverBuilderClass(static::getDefaults());
    }

    /**
     * @throws DomainException
     */
    public static function createFrom(IPattern $pattern): IRevolver
    {
        foreach (static::revolverFactories() as $patternClass => $revolverFactory) {
            if ($pattern instanceof $patternClass) {
                dump(get_debug_type($pattern), $patternClass, $revolverFactory);
                return
                    $revolverFactory::create(
                        $pattern,
                        $pattern->getInterval()
                    );
            }
        }
        self::throwUnknownPatternType($pattern, __METHOD__);
    }

    abstract protected static function create(IPattern $pattern, IInterval $interval): IRevolver;

//    public static function createFrom(IPattern $pattern): IRevolver
//    {
//        if ($pattern instanceof IProceduralPattern) {
//            $revolver = new ProceduralRevolver(
//                $pattern->getProcedure(),
//                $pattern->getInterval()
//            );
////            if ($pattern instanceof AProceduralStylePattern) {
////                self::assertIsStylePattern($revolver);
////            }
//            return
//                $revolver;
//        }
//        if ($pattern instanceof IStylePattern) {
//            return
//                new FrameCollectionRevolver(
//                    (new StyleFrameRenderer($pattern))->render(),
//                    $pattern->getInterval()
//                );
//        }
//        return
//            new FrameCollectionRevolver(
//                (new FrameRenderer($pattern))->render(),
//                $pattern->getInterval()
//            );
//    }

    /**
     * @throws DomainException
     */
    protected static function throwUnknownPatternType(IPattern $pattern, string $method): void
    {
        throw new DomainException(
            sprintf(
                'Unknown pattern type %s in %s.',
                get_debug_type($pattern),
                $method
            )
        );
    }

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

    /**
     * @throws DomainException
     */
    protected static function assertIsStylePattern(IRevolver $revolver): void
    {
        // assert that revolver output has '%s' placeholder in Frame sequence of first frame
        $frame = $revolver->update();
        if (!str_contains($frame->sequence(), '%s')) {
            throw new DomainException(
                sprintf(
                    '%s: Revolver output has no \'%%s\' placeholder in Frame sequence.',
                    static::class
                )
            );
        }
    }
}