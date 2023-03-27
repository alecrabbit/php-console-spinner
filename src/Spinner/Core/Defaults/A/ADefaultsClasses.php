<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Contract\IAnsiStyleConverter;
use AlecRabbit\Spinner\Core\Color\AnsiStyleConverter;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaultsClasses;
use AlecRabbit\Spinner\Core\DriverBuilder;
use AlecRabbit\Spinner\Core\FrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolverBuilder;
use AlecRabbit\Spinner\Helper\Asserter;

abstract class ADefaultsClasses extends ADefaultsChild implements IDefaultsClasses
{
    /** @var class-string<IDriverBuilder> */
    final protected const DRIVER_BUILDER_CLASS = DriverBuilder::class;

    /** @var class-string<IWidgetBuilder> */
    final protected const WIDGET_BUILDER_CLASS = WidgetBuilder::class;

    /** @var class-string<IWidgetRevolverBuilder> */
    final protected const WIDGET_REVOLVER_BUILDER_CLASS = WidgetRevolverBuilder::class;

    /** @var class-string<IFrameRevolverBuilder> */
    final protected const FRAME_REVOLVER_BUILDER_CLASS = FrameRevolverBuilder::class;

    /** @var class-string<IAnsiStyleConverter> */
    final protected const ANSI_STYLE_CONVERTER_CLASS = AnsiStyleConverter::class;

    /** @var class-string<IDriverBuilder> */
    protected static string $driverBuilderClass;

    /** @var null|class-string<IDriverBuilder> */
    protected static ?string $driverBuilderClassOverride = null;

    /** @var class-string<IWidgetBuilder> */
    protected static string $widgetBuilderClass;

    /** @var null|class-string<IWidgetBuilder> */
    protected static ?string $widgetBuilderClassOverride = null;

    /** @var class-string<IWidgetRevolverBuilder> */
    protected static string $widgetRevolverBuilderClass;


    /** @var null|class-string<IWidgetRevolverBuilder> */
    protected static ?string $widgetRevolverBuilderClassOverride = null;

    /** @var class-string<IFrameRevolverBuilder> */
    protected static string $frameRevolverBuilderClass;

    /** @var null|class-string<IFrameRevolverBuilder> */
    protected static ?string $frameRevolverBuilderClassOverride = null;

    /** @var class-string<IAnsiStyleConverter> */
    protected static string $ansiStyleConverterClass;

    /** @var null|class-string<IAnsiStyleConverter> */
    protected static ?string $ansiStyleConverterClassOverride = null;

    private static ?IDefaultsClasses $objInstance = null; // private, singleton

    final protected function __construct(IDefaults $parent)
    {
        parent::__construct($parent);
        $this->reset();
    }

    protected function reset(): void
    {
        static::$driverBuilderClass =
            static::$driverBuilderClassOverride ?? static::DRIVER_BUILDER_CLASS;

        static::$widgetBuilderClass =
            static::$widgetBuilderClassOverride ?? static::WIDGET_BUILDER_CLASS;

        static::$widgetRevolverBuilderClass =
            static::$widgetRevolverBuilderClassOverride ?? static::WIDGET_REVOLVER_BUILDER_CLASS;

        static::$frameRevolverBuilderClass =
            static::$frameRevolverBuilderClassOverride ?? static::FRAME_REVOLVER_BUILDER_CLASS;

        static::$ansiStyleConverterClass =
            static::$ansiStyleConverterClassOverride ?? static::ANSI_STYLE_CONVERTER_CLASS;
    }

    final public static function getInstance(IDefaults $parent): IDefaultsClasses
    {
        if (null === self::$objInstance) {
            self::$objInstance =
                new class ($parent) extends ADefaultsClasses {
                };
        }
        return self::$objInstance;
    }

    /** @inheritDoc */
    public static function overrideFrameRevolverBuilderClass(string $frameRevolverBuilderClass): void
    {
        Asserter::isSubClass($frameRevolverBuilderClass, IFrameRevolverBuilder::class, __METHOD__);
        self::$frameRevolverBuilderClassOverride = $frameRevolverBuilderClass;
    }

    /** @inheritDoc */
    public function getWidgetBuilderClass(): string
    {
        return self::$widgetBuilderClass;
    }

    /** @inheritDoc */
    public function overrideWidgetBuilderClass(string $widgetBuilderClass): void
    {
        Asserter::isSubClass($widgetBuilderClass, IWidgetBuilder::class, __METHOD__);
        self::$widgetBuilderClass = $widgetBuilderClass;
    }

    /** @inheritDoc */
    public function getWidgetRevolverBuilderClass(): string
    {
        return self::$widgetRevolverBuilderClass;
    }

    /** @inheritDoc */
    public function overrideWidgetRevolverBuilderClass(string $widgetRevolverBuilderClass): void
    {
        Asserter::isSubClass($widgetRevolverBuilderClass, IWidgetRevolverBuilder::class, __METHOD__);
        self::$widgetRevolverBuilderClass = $widgetRevolverBuilderClass;
    }

    /** @inheritDoc */
    public function getDriverBuilderClass(): string
    {
        return self::$driverBuilderClass;
    }

    /** @inheritDoc */
    public function overrideDriverBuilderClass(string $driverBuilderClass): void
    {
        Asserter::isSubClass($driverBuilderClass, IDriverBuilder::class, __METHOD__);
        self::$driverBuilderClass = $driverBuilderClass;
    }

    /** @inheritDoc */
    public function getFrameRevolverBuilderClass(): string
    {
        return self::$frameRevolverBuilderClass;
    }

    /** @inheritDoc */
    public function getAnsiStyleConverterClass(): string
    {
        return self::$ansiStyleConverterClass;
    }

    /** @inheritDoc */
    public function overrideAnsiStyleConverterClass(string $ansiColorConverterClass): void
    {
        Asserter::isSubClass($ansiColorConverterClass, IAnsiStyleConverter::class, __METHOD__);
        self::$ansiStyleConverterClass = $ansiColorConverterClass;
    }
}
