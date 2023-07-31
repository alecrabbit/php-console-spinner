<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\IFrame;

final class WidgetSettings implements Contract\IWidgetSettings
{

    public function __construct(
        protected ?IFrame $leadingSpacer = null,
        protected ?IFrame $trailingSpacer = null,
        protected mixed $stylePattern = null,
        protected mixed $charPattern = null,
    ) {
    }

    public function getLeadingSpacer(): ?IFrame
    {
        return $this->leadingSpacer;
    }

    public function setLeadingSpacer(?IFrame $leadingSpacer): void
    {
        $this->leadingSpacer = $leadingSpacer;
    }

    public function getTrailingSpacer(): ?IFrame
    {
        return $this->trailingSpacer;
    }

    public function setTrailingSpacer(?IFrame $trailingSpacer): void
    {
        $this->trailingSpacer = $trailingSpacer;
    }
}
