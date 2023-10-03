<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Legacy;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Legacy\ILegacyPattern;
use AlecRabbit\Spinner\Core\Config\Legacy\Contract\ILegacyWidgetConfig;
use AlecRabbit\Spinner\Core\Pattern\Legacy\Contract\IStyleLegacyPattern;

final class LegacyWidgetConfig implements ILegacyWidgetConfig
{
    public function __construct(
        protected ?IFrame $leadingSpacer = null,
        protected ?IFrame $trailingSpacer = null,
        protected ?IStyleLegacyPattern $stylePattern = null,
        protected ?ILegacyPattern $charPattern = null,
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

    public function setStylePattern(?IStyleLegacyPattern $stylePattern): ILegacyWidgetConfig
    {
        $this->stylePattern = $stylePattern;
        return $this;
    }

    public function setCharPattern(?ILegacyPattern $charPattern): ILegacyWidgetConfig
    {
        $this->charPattern = $charPattern;
        return $this;
    }

    /** @inheritDoc */
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

    public function getStylePattern(): ?IStyleLegacyPattern
    {
        return $this->stylePattern;
    }

    public function getCharPattern(): ?ILegacyPattern
    {
        return $this->charPattern;
    }
}
