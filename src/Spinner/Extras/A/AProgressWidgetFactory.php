<?php

declare(strict_types=1);
// 24.02.23
namespace AlecRabbit\Spinner\Extras\A;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IInterval;
use AlecRabbit\Spinner\Core\Revolver\ProceduralRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Contract\IFractionBarSprite;
use AlecRabbit\Spinner\Extras\Contract\IFractionValue;
use AlecRabbit\Spinner\Extras\Contract\IProgressWidgetFactory;
use AlecRabbit\Spinner\Extras\FractionBarSprite;
use AlecRabbit\Spinner\Extras\Procedure\FractionBarProcedure;
use AlecRabbit\Spinner\Extras\Procedure\FractionValueProcedure;
use AlecRabbit\Spinner\Extras\Procedure\StepsProcedure;
use AlecRabbit\Spinner\Factory\A\AWidgetFactory;

abstract class AProgressWidgetFactory extends AWidgetFactory implements IProgressWidgetFactory
{
    public static function createSteps(
        IFractionValue $progressValue,
        ?IInterval $updateInterval = null,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
    ): IWidgetComposite {
        $updateInterval ??= static::getDefaultUpdateInterval();

        $revolver =
            static::getWidgetRevolverBuilder()
                ->withCharRevolver(
                    new ProceduralRevolver(
                        new StepsProcedure(
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
        IFractionValue $progressValue,
        ?IFractionBarSprite $sprite = null,
        ?IInterval $updateInterval = null,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
    ): IWidgetComposite {
        $sprite ??= new FractionBarSprite();

        $procedure =
            new FractionBarProcedure(
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

    public static function createProgressValue(
        IFractionValue $progressValue,
        ?string $format = null,
        ?IInterval $updateInterval = null,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
    ): IWidgetComposite {
        $procedure =
            new FractionValueProcedure(
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