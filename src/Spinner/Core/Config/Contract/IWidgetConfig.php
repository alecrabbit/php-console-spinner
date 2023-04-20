<?php

declare(strict_types=1);

// 12.04.23

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\ILegacyPattern;

interface IWidgetConfig
{
    public function getLeadingSpacer(): ?IFrame;

    public function setLeadingSpacer(?IFrame $leadingSpacer): IWidgetConfig;

    public function getTrailingSpacer(): ?IFrame;

    public function setTrailingSpacer(?IFrame $trailingSpacer): IWidgetConfig;

    public function getStylePattern(): ?ILegacyPattern;

    public function setStylePattern(?ILegacyPattern $stylePattern): IWidgetConfig;

    public function getCharPattern(): ?ILegacyPattern;

    public function setCharPattern(?ILegacyPattern $charPattern): IWidgetConfig;
}
