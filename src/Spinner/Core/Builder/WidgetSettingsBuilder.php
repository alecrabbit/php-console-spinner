<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Exception\LogicException;

final class WidgetSettingsBuilder implements IWidgetSettingsBuilder
{
    private ?IFrame $leadingSpacer = null;
    private ?IFrame $trailingSpacer = null;
    private ?IStylePattern $stylePattern = null;
    private ?IPattern $charPattern = null;

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

    /**
     * @throws LogicException
     */
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

    public function withStylePattern(IStylePattern $pattern): IWidgetSettingsBuilder
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