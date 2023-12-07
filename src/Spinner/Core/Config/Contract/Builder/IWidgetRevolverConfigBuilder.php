<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Builder;

use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Exception\LogicException;

interface IWidgetRevolverConfigBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): IWidgetRevolverConfig;

    public function withStylePalette(IStylePalette $palette): IWidgetRevolverConfigBuilder;

    public function withCharPalette(ICharPalette $palette): IWidgetRevolverConfigBuilder;

    public function withRevolverConfig(IRevolverConfig $revolverConfig): IWidgetRevolverConfigBuilder;
}
