<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;

interface IWidgetConfig
{
    public function getLeadingSpacer(): ?IFrame;

    public function setLeadingSpacer(?IFrame $leadingSpacer): IWidgetConfig;

    public function getTrailingSpacer(): ?IFrame;

    public function setTrailingSpacer(?IFrame $trailingSpacer): IWidgetConfig;

    public function getStylePattern(): ?IPattern;

    public function setStylePattern(?IPattern $stylePattern): IWidgetConfig;

    public function getCharPattern(): ?IPattern;

    public function setCharPattern(?IPattern $charPattern): IWidgetConfig;

    public function merge(IWidgetConfig $other): IWidgetConfig;
}
