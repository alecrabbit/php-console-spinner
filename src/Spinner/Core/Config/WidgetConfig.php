<?php

declare(strict_types=1);

// 12.04.23

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\ILegacyPattern;

final class WidgetConfig implements Contract\IWidgetConfig
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

    public function getTrailingSpacer(): ?IFrame
    {
        return $this->trailingSpacer;
    }

    public function getStylePattern(): ?ILegacyPattern
    {
        return $this->stylePattern;
    }

    public function getCharPattern(): ?ILegacyPattern
    {
        return $this->charPattern;
    }
}
