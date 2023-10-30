<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;

final readonly class RootWidgetConfig implements IRootWidgetConfig
{
    public function __construct(
        protected IFrame $leadingSpacer,
        protected IFrame $trailingSpacer,
        protected IWidgetRevolverConfig $revolverConfig,
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

    public function getWidgetRevolverConfig(): IWidgetRevolverConfig
    {
        return $this->revolverConfig;
    }

    /**
     * @return class-string<IRootWidgetConfig>
     */
    public function getIdentifier(): string
    {
        return IRootWidgetConfig::class;
    }
}
