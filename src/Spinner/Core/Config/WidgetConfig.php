<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;

final readonly class WidgetConfig implements IWidgetConfig
{
    public function __construct(
        protected IFrame $leadingSpacer,
        protected IFrame $trailingSpacer,
        protected IRevolverConfig $revolverConfig,
    ) {
    }

    public function getLeadingSpacer(): IFrame
    {
        return $this->leadingSpacer;
    }

    public function getTrailingSpacer(): IFrame
    {
        return $this->trailingSpacer;
    }

    public function getRevolverConfig(): IRevolverConfig
    {
        return $this->revolverConfig;
    }
}
