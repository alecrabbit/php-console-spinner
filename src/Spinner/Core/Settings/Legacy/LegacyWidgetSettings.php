<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Legacy;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Legacy\ILegacyPattern;
use AlecRabbit\Spinner\Core\Pattern\Legacy\Contract\IStyleLegacyPattern;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyWidgetSettings;

/**
 * @deprecated Will be removed
 */
final class LegacyWidgetSettings implements ILegacyWidgetSettings
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

    public function setLeadingSpacer(IFrame $frame): ILegacyWidgetSettings
    {
        $this->leadingSpacer = $frame;
        return $this;
    }

    public function getTrailingSpacer(): IFrame
    {
        return $this->trailingSpacer;
    }

    public function setTrailingSpacer(IFrame $frame): ILegacyWidgetSettings
    {
        $this->trailingSpacer = $frame;
        return $this;
    }

    public function getStylePattern(): IStyleLegacyPattern
    {
        return $this->stylePattern;
    }

    public function setStylePattern(IStyleLegacyPattern $pattern): ILegacyWidgetSettings
    {
        $this->stylePattern = $pattern;
        return $this;
    }

    public function getCharPattern(): ILegacyPattern
    {
        return $this->charPattern;
    }

    public function setCharPattern(ILegacyPattern $pattern): ILegacyWidgetSettings
    {
        $this->charPattern = $pattern;
        return $this;
    }
}
