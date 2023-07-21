<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Config\Contract\ILegacyWidgetConfig;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;

final class LegacyWidgetConfig implements ILegacyWidgetConfig
{
    public function __construct(
        protected ?IFrame $leadingSpacer = null,
        protected ?IFrame $trailingSpacer = null,
        protected ?IStylePattern $stylePattern = null,
        protected ?IPattern $charPattern = null,
    ) {
    }

    public function setLeadingSpacer(?IFrame $leadingSpacer): ILegacyWidgetConfig
    {
        $this->leadingSpacer = $leadingSpacer;
        return $this;
    }

    public function setTrailingSpacer(?IFrame $trailingSpacer): ILegacyWidgetConfig
    {
        $this->trailingSpacer = $trailingSpacer;
        return $this;
    }

    public function setStylePattern(?IStylePattern $stylePattern): ILegacyWidgetConfig
    {
        $this->stylePattern = $stylePattern;
        return $this;
    }

    public function setCharPattern(?IPattern $charPattern): ILegacyWidgetConfig
    {
        $this->charPattern = $charPattern;
        return $this;
    }

    /** @inheritdoc */
    public function merge(ILegacyWidgetConfig $other): ILegacyWidgetConfig
    {
        return
            new LegacyWidgetConfig(
                $this->leadingSpacer ?? $other->getLeadingSpacer(),
                $this->trailingSpacer ?? $other->getTrailingSpacer(),
                $this->stylePattern ?? $other->getStylePattern(),
                $this->charPattern ?? $other->getCharPattern(),
            );
    }

    public function getLeadingSpacer(): ?IFrame
    {
        return $this->leadingSpacer;
    }

    public function getTrailingSpacer(): ?IFrame
    {
        return $this->trailingSpacer;
    }

    public function getStylePattern(): ?IStylePattern
    {
        return $this->stylePattern;
    }

    public function getCharPattern(): ?IPattern
    {
        return $this->charPattern;
    }
}
