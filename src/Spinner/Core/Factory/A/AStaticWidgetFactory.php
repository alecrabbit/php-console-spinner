<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Factory\Contract\IStaticWidgetFactory;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Factory\StaticIntervalFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\EmptyFrameRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;

abstract class AStaticWidgetFactory extends ADefaultsAwareClass implements IStaticWidgetFactory
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
                ->build()
        ;
    }

    public static function getWidgetBuilder(?IDefaults $defaults = null): IWidgetBuilder
    {
        if (null === static::$widgetBuilder) {
            static::$widgetBuilder = self::createWidgetBuilder($defaults);
        }
        return static::$widgetBuilder;
    }

    protected static function createWidgetBuilder(?IDefaults $defaults): IWidgetBuilder
    {
        $defaults ??= static::getDefaults();

        $widgetBuilderClass = $defaults->getClasses()->getWidgetBuilderClass();

        return
            new $widgetBuilderClass(
                static::getDefaults(),
                static::getWidgetRevolverBuilder($defaults),
            );
    }

    public static function getWidgetRevolverBuilder(?IDefaults $defaults = null): IWidgetRevolverBuilder
    {
        if (null === static::$widgetRevolverBuilder) {
            static::$widgetRevolverBuilder = static::createWidgetRevolverBuilder($defaults);
        }
        return static::$widgetRevolverBuilder;
    }

    protected static function createWidgetRevolverBuilder(?IDefaults $defaults): IWidgetRevolverBuilder
    {
        $defaults ??= static::getDefaults();

        $widgetRevolverBuilderClass = $defaults->getClasses()->getWidgetRevolverBuilderClass();

        return
            new $widgetRevolverBuilderClass(
                static::getDefaults(),
            );
    }

    protected static function getDefaultUpdateInterval(): IInterval
    {
        return StaticIntervalFactory::createDefault();
    }
}
