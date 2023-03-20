<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaultsClasses;
use AlecRabbit\Spinner\Core\DriverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolverBuilder;
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

    /** @var class-string<IRevolverBuilder> */
    final protected const REVOLVER_BUILDER_CLASS = RevolverBuilder::class;

    /** @var class-string<IDriverBuilder> */
    protected static string $driverBuilderClass;

    /** @var class-string<IWidgetBuilder> */
    protected static string $widgetBuilderClass;

    /** @var class-string<IWidgetRevolverBuilder> */
    protected static string $widgetRevolverBuilderClass;

    /** @var class-string<IRevolverBuilder> */
    protected static string $revolverBuilderClass;

    private static ?IDefaultsClasses $objInstance = null; // private, singleton

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
        static::$revolverBuilderClass = static::REVOLVER_BUILDER_CLASS;
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
    public function getWidgetBuilderClass(): string
    {
        return self::$widgetBuilderClass;
    }

    /** @inheritDoc */
    public function setWidgetBuilderClass(string $widgetBuilderClass): void
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
    public function setWidgetRevolverBuilderClass(string $widgetRevolverBuilderClass): void
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
    public function setDriverBuilderClass(string $driverBuilderClass): void
    {
        Asserter::isSubClass($driverBuilderClass, IDriverBuilder::class, __METHOD__);
        self::$driverBuilderClass = $driverBuilderClass;
    }

    /** @inheritDoc */
    public function getRevolverBuilderClass(): string
    {
        return self::$revolverBuilderClass;
    }

    /**
     * @inheritDoc
     */
    public function setRevolverBuilderClass(string $revolverBuilderClass): void
    {
        Asserter::isSubClass($revolverBuilderClass, IRevolverBuilder::class, __METHOD__);
        self::$revolverBuilderClass = $revolverBuilderClass;
    }
}
