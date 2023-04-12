<?php

declare(strict_types=1);
// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Pattern\CharPattern\NoCharPattern;
use AlecRabbit\Spinner\Core\Pattern\StylePattern\NoStylePattern;

final class WidgetSettingsBuilder implements IWidgetSettingsBuilder
{
    protected ?IFrame $leadingSpacer = null;
    protected ?IFrame $trailingSpacer = null;
    protected ?IPattern $stylePattern = null;
    protected ?IPattern $charPattern = null;

    /** @inheritdoc */
    public function build(): IWidgetSettings
    {
        return
            new WidgetSettings(
                leadingSpacer: $this->leadingSpacer ??= FrameFactory::createEmpty(),
                trailingSpacer: $this->trailingSpacer ??= FrameFactory::createSpace(),
                stylePattern: $this->stylePattern ??= new NoStylePattern(),
                charPattern: $this->charPattern ??= new NoCharPattern(),
            );
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
