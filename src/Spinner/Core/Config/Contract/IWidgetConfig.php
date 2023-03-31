<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;

interface IWidgetConfig
{

    public function getLeadingSpacer(): IFrame;

    public function getTrailingSpacer(): IFrame;

    public function getStylePattern(): IPattern;

    public function getCharPattern(): IPattern;
}
