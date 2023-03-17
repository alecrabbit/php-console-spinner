<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaultsClasses;
use AlecRabbit\Spinner\Core\DriverBuilder;
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

    /** @var class-string<IDriverBuilder> */
    protected static string $driverBuilderClass;

    /** @var class-string<IWidgetBuilder> */
    protected static string $widgetBuilderClass;

    /** @var class-string<IWidgetRevolverBuilder> */
    protected static string $widgetRevolverBuilderClass;
    
    private static ?IDefaultsClasses $objectInstance = null;

    final protected function __construct(IDefaults $parent)
    {
        parent::__construct($parent);
        $this->reset();
    }

    protected function reset(): void
    {
        static::$driverBuilderClass = static::DRIVER_BUILDER_CLASS;
        static::$widgetBuilderClass = static::WIDGET_BUILDER_CLASS;
        static::$widgetRevolverBuilderClass = static::WIDGET_REVOLVER_BUILDER_CLASS;
    }

    final public static function getInstance(IDefaults $parent): IDefaultsClasses
    {
        if (null === self::$objectInstance) {
            self::$objectInstance =
                new class ($parent) extends ADefaultsClasses {
                };
        }
        return self::$objectInstance;
    }

    /**
     * @inheritdoc
     */
    public function getWidgetBuilderClass(): string
    {
        return self::$widgetBuilderClass;
    }

    /**
     * @inheritdoc
     */
    public function setWidgetBuilderClass(string $widgetBuilderClass): void
    {
        Asserter::isSubClass($widgetBuilderClass, IWidgetBuilder::class, __METHOD__);
        self::$widgetBuilderClass = $widgetBuilderClass;
    }

    /**
     * @inheritdoc
     */
    public function getWidgetRevolverBuilderClass(): string
    {
        return self::$widgetRevolverBuilderClass;
    }

    /**
     * @inheritdoc
     */
    public function setWidgetRevolverBuilderClass(string $widgetRevolverBuilderClass): void
    {
        Asserter::isSubClass($widgetRevolverBuilderClass, IWidgetRevolverBuilder::class, __METHOD__);
        self::$widgetRevolverBuilderClass = $widgetRevolverBuilderClass;
    }

    /**
     * @inheritDoc
     */
    public function getDriverBuilderClass(): string
    {
        return self::$driverBuilderClass;
    }

    /**
     * @inheritDoc
     */
    public function setDriverBuilderClass(string $driverBuilderClass): void
    {
        Asserter::isSubClass($driverBuilderClass, IDriverBuilder::class, __METHOD__);
        self::$driverBuilderClass = $driverBuilderClass;
    }
}
