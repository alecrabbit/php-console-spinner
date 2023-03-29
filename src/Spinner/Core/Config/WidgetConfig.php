<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;

final class WidgetConfig implements IWidgetConfig
{
    public function __construct()
    {
    }

    public function getLeadingSpacer(): IFrame
    {
        // TODO: Implement getLeadingSpacer() method.
    }

    public function getTrailingSpacer(): IFrame
    {
        // TODO: Implement getTrailingSpacer() method.
    }
}