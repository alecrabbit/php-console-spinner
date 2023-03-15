<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaultsClasses;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolverBuilder;
use AlecRabbit\Spinner\Helper\Asserter;

abstract class ADefaultsClasses implements IDefaultsClasses
{
    final protected const WIDGET_BUILDER_CLASS = WidgetBuilder::class;
    final protected const WIDGET_REVOLVER_BUILDER_CLASS = WidgetRevolverBuilder::class;

    protected static string $widgetBuilderClass;
    protected static string $widgetRevolverBuilderClass;
    private static ?IDefaultsClasses $instance = null;

    final protected function __construct()
    {
        $this->reset();
    }

    protected function reset(): void
    {
        self::$widgetBuilderClass = self::WIDGET_BUILDER_CLASS;
        self::$widgetRevolverBuilderClass = self::WIDGET_REVOLVER_BUILDER_CLASS;
    }

    final public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance =
                new class() extends ADefaultsClasses {
                };
        }
        return self::$instance;
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
}
