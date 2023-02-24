<?php

declare(strict_types=1);
// 24.02.23
namespace AlecRabbit\Spinner\Factory\A;

use AlecRabbit\Spinner\Core\Contract\IFractionValue;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IInterval;
use AlecRabbit\Spinner\Core\Procedure\StepsProcedure;
use AlecRabbit\Spinner\Core\Revolver\ProceduralRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Factory\Contract\IProgressWidgetFactory;
use AlecRabbit\Spinner\Factory\IntervalFactory;

abstract class AProgressWidgetFactory extends AWidgetFactory implements IProgressWidgetFactory
{
    public static function createSteps(
        IFractionValue $progressValue,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
        ?IInterval $updateInterval = null
    ): IWidgetComposite {
        //        $widgetBuilder
        //            ->withWidgetRevolver(
        //                $widgetRevolverBuilder
        //                    ->withCharRevolver(
        //                        new ProceduralRevolver(
        //                            new StepsProcedure(
        //                                $progressValue,
        //                            ),
        //                            $progressUpdateInterval
        //                        ),
        //                    )
        //                    ->build()
        //            )
        //            ->withLeadingSpacer(Frame::createSpace())
        //            ->build();
        $updateInterval ??= static::getDefaultUpdateInterval();
        return
            static::getWidgetBuilder()
                ->withWidgetRevolver(
                    static::getWidgetRevolverBuilder()
                        ->withCharRevolver(
                            new ProceduralRevolver(
                                new StepsProcedure(
                                    $progressValue,
                                ),
                                $updateInterval
                            )
                        )
                        ->build()
                )
                ->withLeadingSpacer($leadingSpacer)
                ->withTrailingSpacer($trailingSpacer)
                ->build();
    }

    protected static function getDefaultUpdateInterval(): IInterval
    {
        return IntervalFactory::createDefault();
    }
}