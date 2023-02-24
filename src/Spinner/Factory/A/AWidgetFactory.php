<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory\A;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\EmptyFrameRevolver;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Factory\Contract\IWidgetFactory;

abstract class AWidgetFactory extends ADefaultsAwareClass implements IWidgetFactory
{
    protected static ?IWidgetBuilder $widgetBuilder = null;
    protected static ?IWidgetRevolverBuilder $widgetRevolverBuilder = null;

    /** @inheritdoc */
    public static function createEmpty(): IWidgetComposite
    {
        return
            static::getWidgetBuilder()
                ->withWidgetRevolver(EmptyFrameRevolver::create())
                ->withLeadingSpacer(Frame::createEmpty())
                ->withTrailingSpacer(Frame::createEmpty())
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

    public static function create(
        ?IFrame $leadingSpacer = null,
        ?IFrame $trailingSpacer = null,
    ): IWidgetComposite {
        return
            static::getWidgetBuilder()
                ->withLeadingSpacer($leadingSpacer)
                ->withTrailingSpacer($trailingSpacer)
                ->build();
    }
}
