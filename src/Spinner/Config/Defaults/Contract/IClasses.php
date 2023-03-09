<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Config\Defaults\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IClasses
{
    /**
     * @return  class-string
     */
    public function getWidgetBuilderClass(): string;

    /**
     * @param class-string $widgetBuilderClass
     * @throws InvalidArgumentException
     */
    public function setWidgetBuilderClass(string $widgetBuilderClass): void;

    /**
     * @return  class-string
     */
    public function getWidgetRevolverBuilderClass(): string;

    /**
     * @param class-string $widgetRevolverBuilderClass
     * @throws InvalidArgumentException
     */
    public function setWidgetRevolverBuilderClass(string $widgetRevolverBuilderClass): void;
}
