<?php

declare(strict_types=1);
// 16.03.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Factory\A\ARevolverFactory;
use AlecRabbit\Spinner\Core\FrameRenderer;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use AlecRabbit\Spinner\Core\StyleFrameRenderer;

final class RevolverFactory extends ARevolverFactory
{


    protected static function create(IPattern $pattern, IInterval $interval): IRevolver
    {
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

    protected static function revolverFactories(): iterable
    {
        yield from [
            IPattern::class => self::class,
        ];
    }
}