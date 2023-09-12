<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Builder;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Exception\LogicException;

interface IWidgetConfigBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): IWidgetConfig;

    public function withLeadingSpacer(IFrame $frame): IWidgetConfigBuilder;

    public function withTrailingSpacer(IFrame $frame): IWidgetConfigBuilder;

    public function withStylePalette(IPalette $pattern): IWidgetConfigBuilder;

    public function withCharPalette(IPalette $pattern): IWidgetConfigBuilder;

    public function withRevolverConfig(IWidgetRevolverConfig $revolverConfig): IWidgetConfigBuilder;
}
