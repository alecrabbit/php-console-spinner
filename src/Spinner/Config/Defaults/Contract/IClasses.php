<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Config\Defaults\Contract;

interface IClasses
{
    /**
     * @return  class-string
     */
    public function getWidgetBuilderClass(): string;

    /**
     * @return  class-string
     */
    public function getWidgetRevolverBuilderClass(): string;
}
