<?php

declare(strict_types=1);
// 15.03.23
namespace AlecRabbit\Spinner\Core\Config\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfigBuilder;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;

abstract class AWidgetConfigBuilder implements IWidgetConfigBuilder
{
    protected ?IRevolver $styleRevolver = null;
    protected ?IRevolver $charRevolver = null;
    protected ?IPattern $stylePattern = null;
    protected ?IPattern $charPattern = null;
    protected ?IFrame $leadingSpacer = null;
    protected ?IFrame $trailingSpacer = null;

    public function __construct(
        protected IDefaults $defaults,
    ) {
    }

    public function withStyleRevolver(IRevolver $revolver): static
    {
        $clone = clone $this;
        $clone->styleRevolver = $revolver;
        return $clone;
    }

    public function withCharRevolver(IRevolver $revolver): static
    {
        $clone = clone $this;
        $clone->charRevolver = $revolver;
        return $clone;
    }

    public function withStylePattern(IPattern $pattern): static
    {
        $clone = clone $this;
        $clone->stylePattern = $pattern;
        return $clone;
    }

    public function withCharPattern(IPattern $pattern): static
    {
        $clone = clone $this;
        $clone->charPattern = $pattern;
        return $clone;
    }

    public function withLeadingSpacer(IFrame $frame): static
    {
        $clone = clone $this;
        $clone->leadingSpacer = $frame;
        return $clone;
    }

    public function withTrailingSpacer(IFrame $frame): static
    {
        $clone = clone $this;
        $clone->trailingSpacer = $frame;
        return $clone;
    }

    public function build(): IWidgetConfig
    {
        $this->processDefaults();

        return
            new WidgetConfig(
                $this->styleRevolver,
                $this->charRevolver,
                $this->stylePattern,
                $this->charPattern,
                $this->leadingSpacer,
                $this->trailingSpacer,
            );
    }

    protected function processDefaults(): void
    {
    }
}