<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPatternMarker;

interface IWidgetConfig
{
    public function getLeadingSpacer(): IFrame;

    public function getTrailingSpacer(): IFrame;

    public function getStylePattern(): IPatternMarker;

    public function getCharPattern(): IPatternMarker;
}
