<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IWidgetConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Exception\LogicException;

final class WidgetConfigBuilder implements IWidgetConfigBuilder
{
    private ?IFrame $leadingSpacer = null;
    private ?IFrame $trailingSpacer = null;
    private ?IPalette $stylePattern = null;
    private ?IPalette $charPattern = null;

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
                stylePalette: $this->stylePattern,
                charPalette: $this->charPattern,
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

    public function withStylePalette(IPalette $pattern): IWidgetConfigBuilder
    {
        $clone = clone $this;
        $clone->stylePattern = $pattern;
        return $clone;
    }

    public function withCharPalette(IPalette $pattern): IWidgetConfigBuilder
    {
        $clone = clone $this;
        $clone->charPattern = $pattern;
        return $clone;
    }
}
