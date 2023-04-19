<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\ILegacyPattern;

interface IWidgetSettings
{
    public function getLeadingSpacer(): IFrame;

    public function setLeadingSpacer(IFrame $frame): IWidgetSettings;

    public function getTrailingSpacer(): IFrame;

    public function setTrailingSpacer(IFrame $frame): IWidgetSettings;

    public function getStylePattern(): ILegacyPattern;

    public function setStylePattern(ILegacyPattern $pattern): IWidgetSettings;

    public function getCharPattern(): ILegacyPattern;

    public function setCharPattern(ILegacyPattern $pattern): IWidgetSettings;
}
