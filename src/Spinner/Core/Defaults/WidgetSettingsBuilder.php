<?php

declare(strict_types=1);
// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Exception\LogicException;

final class WidgetSettingsBuilder implements IWidgetSettingsBuilder
{
    protected ?IFrame $leadingSpacer = null;
    protected ?IFrame $trailingSpacer = null;
    protected ?IPattern $stylePattern = null;
    protected ?IPattern $charPattern = null;

    /** @inheritdoc */
    public function build(): IWidgetSettings
    {
        $this->validate();

        return
            new WidgetSettings(
                leadingSpacer: $this->leadingSpacer,
                trailingSpacer: $this->trailingSpacer,
                stylePattern: $this->stylePattern,
                charPattern: $this->charPattern,
            );
    }

    protected function validate(): void
    {
        match (true) {
            null === $this->leadingSpacer => throw new LogicException('Leading spacer is not set.'),
            null === $this->trailingSpacer => throw new LogicException('Trailing spacer is not set.'),
            null === $this->stylePattern => throw new LogicException('Style pattern is not set.'),
            null === $this->charPattern => throw new LogicException('Char pattern is not set.'),
            default => null,
        };
    }

    public function withLeadingSpacer(IFrame $frame): IWidgetSettingsBuilder
    {
        $clone = clone $this;
        $clone->leadingSpacer = $frame;
        return $clone;
    }

    public function withTrailingSpacer(IFrame $frame): IWidgetSettingsBuilder
    {
        $clone = clone $this;
        $clone->trailingSpacer = $frame;
        return $clone;
    }

    public function withStylePattern(IPattern $pattern): IWidgetSettingsBuilder
    {
        $clone = clone $this;
        $clone->stylePattern = $pattern;
        return $clone;
    }

    public function withCharPattern(IPattern $pattern): IWidgetSettingsBuilder
    {
        $clone = clone $this;
        $clone->charPattern = $pattern;
        return $clone;
    }
}
