<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;

interface IWidgetSettings
{
    public function getLeadingSpacer(): IFrame;

    public function setLeadingSpacer(IFrame $frame): IWidgetSettings;

    public function getTrailingSpacer(): IFrame;

    public function setTrailingSpacer(IFrame $frame): IWidgetSettings;

    public function getStylePattern(): IStylePattern;

    public function setStylePattern(IStylePattern $pattern): IWidgetSettings;

    public function getCharPattern(): IPattern;

    public function setCharPattern(IPattern $pattern): IWidgetSettings;
}
