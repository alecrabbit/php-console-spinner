<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Config;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Builder\Config\Contract\IWidgetConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Pattern\Contract\IBakedPattern;
use AlecRabbit\Spinner\Exception\LogicException;

final class WidgetConfigBuilder implements IWidgetConfigBuilder
{
    private ?IFrame $leadingSpacer = null;
    private ?IFrame $trailingSpacer = null;
    private ?IBakedPattern $stylePattern = null;
    private ?IBakedPattern $charPattern = null;

    /**
     * @inheritDoc
     */
    public function build(): IWidgetConfig
    {
        $this->validate();

        return
            new WidgetConfig(
                leadingSpacer: $this->leadingSpacer,
                trailingSpacer: $this->trailingSpacer,
                stylePattern: $this->stylePattern,
                charPattern: $this->charPattern,
            );
    }

    private function validate(): void
    {
        match (true) {
            $this->leadingSpacer === null => throw new LogicException('Leading spacer is not set.'),
            $this->trailingSpacer === null => throw new LogicException('Trailing spacer is not set.'),
            $this->stylePattern === null => throw new LogicException('Style pattern is not set.'),
            $this->charPattern === null => throw new LogicException('Char pattern is not set.'),
            default => null,
        };
    }

    public function withLeadingSpacer(IFrame $frame): IWidgetConfigBuilder
    {
        $clone = clone $this;
        $clone->leadingSpacer = $frame;
        return $clone;
    }

    public function withTrailingSpacer(IFrame $frame): IWidgetConfigBuilder
    {
        $clone = clone $this;
        $clone->trailingSpacer = $frame;
        return $clone;
    }

    public function withStylePattern(IBakedPattern $pattern): IWidgetConfigBuilder
    {
        $clone = clone $this;
        $clone->stylePattern = $pattern;
        return $clone;
    }

    public function withCharPattern(IBakedPattern $pattern): IWidgetConfigBuilder
    {
        $clone = clone $this;
        $clone->charPattern = $pattern;
        return $clone;
    }
}
