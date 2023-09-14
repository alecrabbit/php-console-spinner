<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\IFrame;

interface IWidgetConfig extends IConfigElement
{
    public function getLeadingSpacer(): IFrame;

    public function getTrailingSpacer(): IFrame;

    public function getRevolverConfig(): IWidgetRevolverConfig;
}
