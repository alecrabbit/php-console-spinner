<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Contract\OptionAutoStart;
use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Contract\OptionSignalHandlers;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;

final class WidgetSettings implements IWidgetSettings
{

    public function getLeadingSpacer(): IFrame
    {
        // TODO: Implement getLeadingSpacer() method.
    }

    public function setLeadingSpacer(IFrame $frame): IWidgetSettings
    {
        // TODO: Implement setLeadingSpacer() method.
    }

    public function getTrailingSpacer(): IFrame
    {
        // TODO: Implement getTrailingSpacer() method.
    }

    public function setTrailingSpacer(IFrame $frame): IWidgetSettings
    {
        // TODO: Implement setTrailingSpacer() method.
    }

    public function getStylePattern(): ?IPattern
    {
        // TODO: Implement getStylePattern() method.
    }

    public function setStylePattern(IPattern $pattern): IWidgetSettings
    {
        // TODO: Implement setStylePattern() method.
    }

    public function getCharPattern(): ?IPattern
    {
        // TODO: Implement getCharPattern() method.
    }

    public function setCharPattern(IPattern $pattern): IWidgetSettings
    {
        // TODO: Implement setCharPattern() method.
    }
}