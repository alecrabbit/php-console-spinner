<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\ISequenceFrame;

interface IWidgetConfig extends IConfigElement
{
    public function getLeadingSpacer(): ISequenceFrame;

    public function getTrailingSpacer(): ISequenceFrame;

    public function getWidgetRevolverConfig(): IWidgetRevolverConfig;
}
