<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Builder;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPatternMarker;
use AlecRabbit\Spinner\Exception\LogicException;

interface IWidgetConfigBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): IWidgetConfig;

    public function withLeadingSpacer(IFrame $frame): IWidgetConfigBuilder;

    public function withTrailingSpacer(IFrame $frame): IWidgetConfigBuilder;

    public function withStylePattern(IPatternMarker $pattern): IWidgetConfigBuilder;

    public function withCharPattern(IPatternMarker $pattern): IWidgetConfigBuilder;
}
