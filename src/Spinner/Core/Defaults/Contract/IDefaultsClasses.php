<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\IAnsiColorConverter;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IDefaultsClasses extends IDefaultsChild
{
    public static function getInstance(IDefaults $parent): IDefaultsClasses;

    /**
     * @param class-string<IFrameRevolverBuilder> $frameRevolverBuilderClass
     * @throws InvalidArgumentException
     */
    public static function overrideFrameRevolverBuilderClass(string $frameRevolverBuilderClass): void;

    /**
     * @return class-string<IWidgetBuilder>
     */
    public function getWidgetBuilderClass(): string;

    /**
     * @param class-string<IWidgetBuilder> $widgetBuilderClass
     * @throws InvalidArgumentException
     */
    public function overrideWidgetBuilderClass(string $widgetBuilderClass): void;

    /**
     * @return class-string<IWidgetRevolverBuilder>
     */
    public function getWidgetRevolverBuilderClass(): string;

    /**
     * @param class-string<IWidgetRevolverBuilder> $widgetRevolverBuilderClass
     * @throws InvalidArgumentException
     */
    public function overrideWidgetRevolverBuilderClass(string $widgetRevolverBuilderClass): void;

    /**
     * @return class-string<IDriverBuilder>
     */
    public function getDriverBuilderClass(): string;

    /**
     * @param class-string<IDriverBuilder> $driverBuilderClass
     * @throws InvalidArgumentException
     */
    public function overrideDriverBuilderClass(string $driverBuilderClass): void;

    /**
     * @return class-string<IFrameRevolverBuilder>
     */
    public function getFrameRevolverBuilderClass(): string;

    /**
     * @return class-string<IAnsiColorConverter>
     */
    public function getAnsiColorConverterClass(): string;

    /**
     * @param class-string<IAnsiColorConverter> $ansiColorConverterClass
     * @throws InvalidArgumentException
     */
    public function overrideAnsiColorConverterClass(string $ansiColorConverterClass): void;
}
