<?php

declare(strict_types=1);

// 12.04.23

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;

final class WidgetConfig implements IWidgetConfig
{
    public function __construct(
        protected ?IFrame $leadingSpacer = null,
        protected ?IFrame $trailingSpacer = null,
        protected ?IPattern $stylePattern = null,
        protected ?IPattern $charPattern = null,
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

    public function getStylePattern(): ?IPattern
    {
        return $this->stylePattern;
    }

    public function setStylePattern(?IPattern $stylePattern): IWidgetConfig
    {
        $this->stylePattern = $stylePattern;
        return $this;
    }

    public function getCharPattern(): ?IPattern
    {
        return $this->charPattern;
    }

    public function setCharPattern(?IPattern $charPattern): IWidgetConfig
    {
        $this->charPattern = $charPattern;
        return $this;
    }

    public function merge(IWidgetConfig $other): IWidgetConfig
    {
        return new WidgetConfig(
            $this->leadingSpacer ?? $other->getLeadingSpacer(),
            $this->trailingSpacer ?? $other->getTrailingSpacer(),
            $this->stylePattern ?? $other->getStylePattern(),
            $this->charPattern ?? $other->getCharPattern(),
        );
    }
}
