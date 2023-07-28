<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Builder;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Pattern\Contract\IBakedPattern;
use AlecRabbit\Spinner\Exception\LogicException;

interface IWidgetConfigBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): IWidgetConfig;

    public function withLeadingSpacer(IFrame $frame): IWidgetConfigBuilder;

    public function withTrailingSpacer(IFrame $frame): IWidgetConfigBuilder;

    public function withStylePattern(IBakedPattern $pattern): IWidgetConfigBuilder;

    public function withCharPattern(IBakedPattern $pattern): IWidgetConfigBuilder;
}
