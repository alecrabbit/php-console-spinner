<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;

final readonly class RootWidgetConfig implements IRootWidgetConfig
{
    public function __construct(
        protected ISequenceFrame $leadingSpacer,
        protected ISequenceFrame $trailingSpacer,
        protected IWidgetRevolverConfig $revolverConfig,
    ) {
    }

    public function getLeadingSpacer(): ISequenceFrame
    {
        return $this->leadingSpacer;
    }

    public function getTrailingSpacer(): ISequenceFrame
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
