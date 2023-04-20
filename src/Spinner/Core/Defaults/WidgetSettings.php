<?php

declare(strict_types=1);

// 29.03.23

namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;

final class WidgetSettings implements IWidgetSettings
{
    public function __construct(
        protected IFrame $leadingSpacer,
        protected IFrame $trailingSpacer,
        protected IStylePattern $stylePattern,
        protected IPattern $charPattern,
    ) {
    }

    public function getLeadingSpacer(): IFrame
    {
        return $this->leadingSpacer;
    }

    public function setLeadingSpacer(IFrame $frame): IWidgetSettings
    {
        $this->leadingSpacer = $frame;
        return $this;
    }

    public function getTrailingSpacer(): IFrame
    {
        return $this->trailingSpacer;
    }

    public function setTrailingSpacer(IFrame $frame): IWidgetSettings
    {
        $this->trailingSpacer = $frame;
        return $this;
    }

    public function getStylePattern(): IStylePattern
    {
        return $this->stylePattern;
    }

    public function setStylePattern(IStylePattern $pattern): IWidgetSettings
    {
        $this->stylePattern = $pattern;
        return $this;
    }

    public function getCharPattern(): IPattern
    {
        return $this->charPattern;
    }

    public function setCharPattern(IPattern $pattern): IWidgetSettings
    {
        $this->charPattern = $pattern;
        return $this;
    }
}
