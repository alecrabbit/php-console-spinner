<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IDefaultsClasses extends IDefaultsChild
{
    public static function getInstance(IDefaults $parent): static;

    /**
     * @return  class-string<IWidgetBuilder>
     */
    public function getWidgetBuilderClass(): string;

    /**
     * @param class-string<IWidgetBuilder> $widgetBuilderClass
     * @throws InvalidArgumentException
     */
    public function setWidgetBuilderClass(string $widgetBuilderClass): void;

    /**
     * @return  class-string<IWidgetRevolverBuilder>
     */
    public function getWidgetRevolverBuilderClass(): string;

    /**
     * @param class-string<IWidgetRevolverBuilder> $widgetRevolverBuilderClass
     * @throws InvalidArgumentException
     */
    public function setWidgetRevolverBuilderClass(string $widgetRevolverBuilderClass): void;

    /**
     * @return  class-string<IDriverBuilder>
     */
    public function getDriverBuilderClass(): string;

    /**
     * @param class-string<IDriverBuilder> $driverBuilderClass
     * @throws InvalidArgumentException
     */
    public function setDriverBuilderClass(string $driverBuilderClass): void;
}
