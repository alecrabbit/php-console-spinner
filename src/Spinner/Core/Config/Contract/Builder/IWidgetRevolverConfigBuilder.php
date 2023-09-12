<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Builder;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Exception\LogicException;

interface IWidgetRevolverConfigBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): IWidgetRevolverConfig;

    public function withStylePalette(IPalette $palette): IWidgetRevolverConfigBuilder;

    public function withCharPalette(IPalette $palette): IWidgetRevolverConfigBuilder;
}
