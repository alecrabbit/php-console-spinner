<?php

declare(strict_types=1);
// 16.03.23
namespace AlecRabbit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Contract\IProceduralPattern;
use AlecRabbit\Spinner\Core\Factory\Contract\IRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalFactory;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Core\FrameRenderer;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use AlecRabbit\Spinner\Core\StyleFrameRenderer;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Extras\Procedure\A\AProceduralStylePattern;
use AlecRabbit\Spinner\Extras\Revolver\ProceduralRevolver;
use ArrayObject;

// FIXME class has a dependency on Procedural functionality
abstract class ARevolverFactory implements IRevolverFactory
{

    public static function createFrom(IPattern $pattern): IRevolver
    {
        if ($pattern instanceof IProceduralPattern) {
            $revolver = new ProceduralRevolver(
                $pattern->getProcedure(),
                $pattern->getInterval()
            );
            if ($pattern instanceof AProceduralStylePattern) {
                self::assertIsStylePattern($revolver);
            }
            return
                $revolver;
        }
        if ($pattern instanceof IStylePattern) {
            return
                new FrameCollectionRevolver(
                    (new StyleFrameRenderer($pattern))->render(),
                    $pattern->getInterval()
                );
        }
        return
            new FrameCollectionRevolver(
                (new FrameRenderer($pattern))->render(),
                $pattern->getInterval()
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
}