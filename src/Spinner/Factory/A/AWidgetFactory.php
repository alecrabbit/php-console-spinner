<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory\A;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IInterval;
use AlecRabbit\Spinner\Core\EmptyFrameRevolver;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Procedure\Contract\IProcedure;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\ProceduralRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Factory\Contract\IWidgetFactory;
use AlecRabbit\Spinner\Factory\IntervalFactory;

abstract class AWidgetFactory extends ADefaultsAwareClass implements IWidgetFactory
{
    protected static ?IWidgetBuilder $widgetBuilder = null;
    protected static ?IWidgetRevolverBuilder $widgetRevolverBuilder = null;

    /** @inheritdoc */
    public static function createEmpty(): IWidgetComposite
    {
        return
            static::create(
                EmptyFrameRevolver::create(),
                Frame::createEmpty(),
                Frame::createEmpty(),
            );
    }

    public static function create(
        IRevolver $revolver,
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
    ): IWidgetComposite {
        return
            static::getWidgetBuilder()
                ->withWidgetRevolver($revolver)
                ->withLeadingSpacer($leadingSpacer)
                ->withTrailingSpacer($trailingSpacer)
                ->build();
    }

    public static function getWidgetBuilder(): IWidgetBuilder
    {
        if (null === static::$widgetBuilder) {
            static::$widgetBuilder = self::createWidgetBuilder();
        }
        return static::$widgetBuilder;
    }

    protected static function createWidgetBuilder(): IWidgetBuilder
    {
        $widgetBuilderClass = self::getDefaults()->getClasses()->getWidgetBuilderClass();

        return
            new $widgetBuilderClass(
                static::getDefaults(),
                static::getWidgetRevolverBuilder(),
            );
    }

    public static function getWidgetRevolverBuilder(): IWidgetRevolverBuilder
    {
        if (null === static::$widgetRevolverBuilder) {
            static::$widgetRevolverBuilder = static::createWidgetRevolverBuilder();
        }
        return static::$widgetRevolverBuilder;
    }

    protected static function createWidgetRevolverBuilder(): IWidgetRevolverBuilder
    {
        $widgetRevolverBuilderClass = self::getDefaults()->getClasses()->getWidgetRevolverBuilderClass();

        return
            new $widgetRevolverBuilderClass(
                static::getDefaults(),
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

    protected static function getDefaultUpdateInterval(): IInterval
    {
        return IntervalFactory::createDefault();
    }
}
