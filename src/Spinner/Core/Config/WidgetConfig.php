<?php

declare(strict_types=1);

// 12.04.23

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\ILegacyPattern;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;

final class WidgetConfig implements IWidgetConfig
{
    public function __construct(
        protected ?IFrame $leadingSpacer = null,
        protected ?IFrame $trailingSpacer = null,
        protected ?ILegacyPattern $stylePattern = null,
        protected ?ILegacyPattern $charPattern = null,
    ) {
    }

    public function getLeadingSpacer(): ?IFrame
    {
        return $this->leadingSpacer;
    }

    public function setLeadingSpacer(?IFrame $leadingSpacer): IWidgetConfig
    {
        $this->leadingSpacer = $leadingSpacer;
        return $this;
    }

    public function getTrailingSpacer(): ?IFrame
    {
        return $this->trailingSpacer;
    }

    public function setTrailingSpacer(?IFrame $trailingSpacer): IWidgetConfig
    {
        $this->trailingSpacer = $trailingSpacer;
        return $this;
    }

    public function getStylePattern(): ?ILegacyPattern
    {
        return $this->stylePattern;
    }

    public function setStylePattern(?ILegacyPattern $stylePattern): IWidgetConfig
    {
        $this->stylePattern = $stylePattern;
        return $this;
    }

    public function getCharPattern(): ?ILegacyPattern
    {
        return $this->charPattern;
    }

    public function setCharPattern(?ILegacyPattern $charPattern): IWidgetConfig
    {
        $this->charPattern = $charPattern;
        return $this;
    }
}
