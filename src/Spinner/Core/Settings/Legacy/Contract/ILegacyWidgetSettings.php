<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Settings\Legacy\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;

interface ILegacyWidgetSettings
{
    public function getLeadingSpacer(): IFrame;

    public function setLeadingSpacer(IFrame $frame): ILegacyWidgetSettings;

    public function getTrailingSpacer(): IFrame;

    public function setTrailingSpacer(IFrame $frame): ILegacyWidgetSettings;

    public function getStylePattern(): IStylePattern;

    public function setStylePattern(IStylePattern $pattern): ILegacyWidgetSettings;

    public function getCharPattern(): IPattern;

    public function setCharPattern(IPattern $pattern): ILegacyWidgetSettings;
}
