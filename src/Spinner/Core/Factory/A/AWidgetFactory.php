<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IInterval;
use AlecRabbit\Spinner\Core\EmptyFrameRevolver;
use AlecRabbit\Spinner\Core\Factory\Contract\IWidgetFactory;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Factory\IntervalFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;

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
                FrameFactory::createEmpty(),
                FrameFactory::createEmpty(),
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

    protected static function getDefaultUpdateInterval(): IInterval
    {
        return IntervalFactory::createDefault();
    }
}
