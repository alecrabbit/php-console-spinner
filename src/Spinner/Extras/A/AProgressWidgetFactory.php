<?php

declare(strict_types=1);
// 24.02.23
namespace AlecRabbit\Spinner\Extras\A;

use AlecRabbit\Spinner\I\IFrame;
use AlecRabbit\Spinner\I\IInterval;
use AlecRabbit\Spinner\I\IProcedure;
use AlecRabbit\Spinner\Core\Factory\A\AWidgetFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Contract\IProgressBarSprite;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\Contract\IProgressWidgetFactory;
use AlecRabbit\Spinner\Extras\Procedure\ProgresBarProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressStepsProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressValueProcedure;
use AlecRabbit\Spinner\Extras\ProgressBarSprite;
use AlecRabbit\Spinner\Extras\Revolver\ProceduralRevolver;

abstract class AProgressWidgetFactory extends AWidgetFactory implements IProgressWidgetFactory
{
    public static function createSteps(
        IProgressValue $progressValue,
        ?IInterval $updateInterval = null,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
    ): IWidgetComposite {
        $updateInterval ??= static::getDefaultUpdateInterval();

        $revolver =
            static::getWidgetRevolverBuilder()
                ->withCharRevolver(
                    new ProceduralRevolver(
                        new ProgressStepsProcedure(
                            $progressValue,
                        ),
                        $updateInterval
                    )
                )
                ->build();

        return
            static::create(
                $revolver,
                $leadingSpacer,
                $trailingSpacer
            );
    }

    public static function createProgressBar(
        IProgressValue $progressValue,
        ?IProgressBarSprite $sprite = null,
        ?IInterval $updateInterval = null,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
    ): IWidgetComposite {
        $sprite ??= new ProgressBarSprite();

        $procedure =
            new ProgresBarProcedure(
                $progressValue,
                $sprite,
            );

        return
            static::createProcedureWidget(
                $procedure,
                $updateInterval,
                $leadingSpacer,
                $trailingSpacer
            );
    }

    public static function createProcedureWidget(
        IProcedure $procedure,
        ?IInterval $updateInterval = null,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
        ?IRevolver $styleRevolver = null,
    ): IWidgetComposite {
        $updateInterval ??= static::getDefaultUpdateInterval();

        $revolver =
            static::getWidgetRevolverBuilder()
                ->withStyleRevolver($styleRevolver)
                ->withCharRevolver(
                    new ProceduralRevolver(
                        $procedure,
                        $updateInterval
                    )
                )
                ->build();

        return
            static::create(
                $revolver,
                $leadingSpacer,
                $trailingSpacer
            );
    }

    public static function createProgressValue(
        IProgressValue $progressValue,
        ?string $format = null,
        ?IInterval $updateInterval = null,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
    ): IWidgetComposite {
        $procedure =
            new ProgressValueProcedure(
                $progressValue,
                $format
            );

        return
            static::createProcedureWidget(
                $procedure,
                $updateInterval,
                $leadingSpacer,
                $trailingSpacer
            );
    }

}