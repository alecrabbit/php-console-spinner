<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Factory\WidgetFactory;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Revolver\ProceduralRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\FractionBarSprite;
use AlecRabbit\Spinner\Extras\FractionValue;
use AlecRabbit\Spinner\Extras\Procedure\FractionBarProcedure;
use AlecRabbit\Spinner\Extras\Procedure\FractionFrameProcedure;
use AlecRabbit\Spinner\Extras\Procedure\FractionValueProcedure;
use AlecRabbit\Spinner\Extras\Procedure\StepsProcedure;

function createProgressWidget(
    FractionValue $progressValue,
    float $interval = null
): IWidgetComposite {
    $interval ??= 0.32;
    $progressUpdateInterval = new Interval($interval * 1000);

    $widgetBuilder = WidgetFactory::getWidgetBuilder();
    $widgetRevolverBuilder = WidgetFactory::getWidgetRevolverBuilder();

    $progressWidget =
        $widgetBuilder
            ->withWidgetRevolver(
                $widgetRevolverBuilder
                    ->withCharRevolver(
                        new ProceduralRevolver(
                            new StepsProcedure(
                                $progressValue,
                            ),
                            $progressUpdateInterval
                        ),
                    )
                    ->build()
            )
            ->withLeadingSpacer(FrameFactory::createSpace())
            ->build();

    $progressWidget->add(
        $widgetBuilder
            ->withWidgetRevolver(
                $widgetRevolverBuilder
                    ->withCharRevolver(
                        new ProceduralRevolver(
                            new FractionFrameProcedure(
                                $progressValue,
                            ),
                            $progressUpdateInterval
                        ),
                    )
                    ->build()
            )
            ->withLeadingSpacer(FrameFactory::createSpace())
            ->build()
    );

    $progressWidget->add(
        $widgetBuilder
            ->withWidgetRevolver(
                $widgetRevolverBuilder
                    ->withCharRevolver(
                        new ProceduralRevolver(
                            new FractionValueProcedure(
                                $progressValue,
                                "%' 5.1f%%"
                            ),
                            $progressUpdateInterval
                        ),
                    )
                    ->build()
            )
            ->build()
    );

    $progressWidget->add(
        $widgetBuilder
            ->withWidgetRevolver(
                $widgetRevolverBuilder
                    ->withCharRevolver(
                        new ProceduralRevolver(
                            new FractionFrameProcedure(
                                $progressValue,
                                [' ', '▏', '▎', '▍', '▌', '▋', '▊', '▉', '█',]
                            ),
                            $progressUpdateInterval
                        ),
                    )
                    ->build()
            )
            ->build()
    );

    $progressWidget->add(
        $widgetBuilder
            ->withWidgetRevolver(
                $widgetRevolverBuilder
                    ->withCharRevolver(
                        new ProceduralRevolver(
                            new FractionBarProcedure(
                                $progressValue,
                                new FractionBarSprite(),
//                                10,
                            ),
                            $progressUpdateInterval
                        ),
                    )
                    ->build()
            )
            ->build()
    );

    $progressWidget->add(
        $widgetBuilder
            ->withWidgetRevolver(
                $widgetRevolverBuilder
                    ->withCharRevolver(
                        new ProceduralRevolver(
                            new FractionValueProcedure(
                                $progressValue,
                            ),
                            $progressUpdateInterval
                        ),
                    )
                    ->build()
            )
            ->build()
    );

    return $progressWidget;
}
