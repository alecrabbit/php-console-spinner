<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Factory\A\AStaticWidgetFactory;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Factory\StaticRevolverFactory;
use AlecRabbit\Spinner\Core\Pattern\CustomCharPattern;
use AlecRabbit\Spinner\Core\Render\CharFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\ILegacyWidgetComposite;
use AlecRabbit\Spinner\Extras\Contract\IProgressBarSprite;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\Contract\IProgressWidgetFactory;
use AlecRabbit\Spinner\Extras\Procedure\ProgressBarProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressFrameProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressStepsProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressValueProcedure;
use AlecRabbit\Spinner\Extras\ProgressBarSprite;
use AlecRabbit\Spinner\Extras\Revolver\ProceduralRevolver;

abstract class AStaticProgressWidgetFactory extends AStaticWidgetFactory implements IProgressWidgetFactory
{
    public static function createProgressSteps(
        IProgressValue $progressValue,
        ?IInterval $updateInterval = null,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
    ): ILegacyWidgetComposite {
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
                ->build()
        ;

        return static::create(
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
    ): ILegacyWidgetComposite {
        $sprite ??= new ProgressBarSprite();

        $procedure =
            new ProgressBarProcedure(
                $progressValue,
                $sprite,
            );

        return static::createProcedureWidget(
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
    ): ILegacyWidgetComposite {
        $updateInterval ??= static::getDefaultUpdateInterval();

        $revolver =
            static::getWidgetRevolverBuilder()
                ->withStyleRevolver(
                    $styleRevolver ?? StaticRevolverFactory::defaultStyleRevolver()
                )
                ->withCharRevolver(
                    new ProceduralRevolver(
                        $procedure,
                        $updateInterval
                    )
                )
                ->build()
        ;

        return static::create(
            $revolver,
            $leadingSpacer,
            $trailingSpacer
        );
    }

    public static function createProgressFrame(
        IProgressValue $progressValue,
        ?IFrameCollection $frames = null,
        ?IInterval $updateInterval = null,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
    ): ILegacyWidgetComposite {
        $frames ??= self::defaultFrames();

        $procedure =
            new ProgressFrameProcedure(
                $progressValue,
                $frames,
            );

        return static::createProcedureWidget(
            $procedure,
            $updateInterval,
            $leadingSpacer,
            $trailingSpacer
        );
    }

    private static function defaultFrames(): IFrameCollection
    {
        $pattern =
            new CustomCharPattern([
                FrameFactory::create(' ', 1),
                FrameFactory::create('▁', 1),
                FrameFactory::create('▂', 1),
                FrameFactory::create('▃', 1),
                FrameFactory::create('▄', 1),
                FrameFactory::create('▅', 1),
                FrameFactory::create('▆', 1),
                FrameFactory::create('▇', 1),
                FrameFactory::create('█', 1),
            ]);

        return (new CharFrameCollectionRenderer())->pattern($pattern)->render();
    }

    public static function createProgressValue(
        IProgressValue $progressValue,
        ?string $format = null,
        ?IInterval $updateInterval = null,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
    ): ILegacyWidgetComposite {
        $procedure =
            new ProgressValueProcedure(
                $progressValue,
                $format
            );

        return static::createProcedureWidget(
            $procedure,
            $updateInterval,
            $leadingSpacer,
            $trailingSpacer
        );
    }
}