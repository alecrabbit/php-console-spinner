<?php

declare(strict_types=1);
// 16.03.23
namespace AlecRabbit\Spinner\Extras;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IProceduralPattern;
use AlecRabbit\Spinner\Core\Factory\A\ARevolverFactory;
use AlecRabbit\Spinner\Core\Factory\RevolverFactory;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Extras\Revolver\ProceduralRevolver;

final class ProceduralRevolverFactory extends ARevolverFactory
{
    /**
     * @throws DomainException
     */
    protected static function create(IPattern $pattern, IInterval $interval): IRevolver
    {
        if ($pattern instanceof IProceduralPattern) {
            return
                new ProceduralRevolver(
                    $pattern->getProcedure(),
                    $pattern->getInterval()
                );
        }
        self::throwUnknownPatternType($pattern, __METHOD__);
    }

    protected static function revolverFactories(): iterable
    {
        yield from [
            IProceduralPattern::class => self::class,
        ];
        yield from [
            IPattern::class => RevolverFactory::class
        ];
    }


}