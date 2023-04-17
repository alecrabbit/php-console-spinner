<?php

declare(strict_types=1);

// 12.04.23

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;

interface IWidgetConfig
{
    public function getLeadingSpacer(): ?IFrame;

    public function getTrailingSpacer(): ?IFrame;

    public function getStylePattern(): ?IPattern;

    public function getCharPattern(): ?IPattern;
}
