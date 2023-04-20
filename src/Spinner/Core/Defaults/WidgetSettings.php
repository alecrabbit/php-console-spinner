<?php

declare(strict_types=1);

// 29.03.23

namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\ILegacyPattern;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStyleLegacyPattern;

final class WidgetSettings implements IWidgetSettings
{
    public function __construct(
        protected IFrame $leadingSpacer,
        protected IFrame $trailingSpacer,
        protected IStyleLegacyPattern $stylePattern,
        protected ILegacyPattern $charPattern,
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

    public function getStylePattern(): IStyleLegacyPattern
    {
        return $this->stylePattern;
    }

    public function setStylePattern(IStyleLegacyPattern $pattern): IWidgetSettings
    {
        $this->stylePattern = $pattern;
        return $this;
    }

    public function getCharPattern(): ILegacyPattern
    {
        return $this->charPattern;
    }

    public function setCharPattern(ILegacyPattern $pattern): IWidgetSettings
    {
        $this->charPattern = $pattern;
        return $this;
    }
}
