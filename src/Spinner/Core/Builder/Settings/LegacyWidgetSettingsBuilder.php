<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder\Settings;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\ILegacyWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\LegacyWidgetSettings;
use AlecRabbit\Spinner\Exception\LogicException;

final class LegacyWidgetSettingsBuilder implements ILegacyWidgetSettingsBuilder
{
    private ?IFrame $leadingSpacer = null;
    private ?IFrame $trailingSpacer = null;
    private ?IStylePattern $stylePattern = null;
    private ?IPattern $charPattern = null;

    public function build(): ILegacyWidgetSettings
    {
        $this->validate();

        return
            new LegacyWidgetSettings(
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

    public function withLeadingSpacer(IFrame $frame): ILegacyWidgetSettingsBuilder
    {
        $clone = clone $this;
        $clone->leadingSpacer = $frame;
        return $clone;
    }

    public function withTrailingSpacer(IFrame $frame): ILegacyWidgetSettingsBuilder
    {
        $clone = clone $this;
        $clone->trailingSpacer = $frame;
        return $clone;
    }

    public function withStylePattern(IStylePattern $pattern): ILegacyWidgetSettingsBuilder
    {
        $clone = clone $this;
        $clone->stylePattern = $pattern;
        return $clone;
    }

    public function withCharPattern(IPattern $pattern): ILegacyWidgetSettingsBuilder
    {
        $clone = clone $this;
        $clone->charPattern = $pattern;
        return $clone;
    }
}
