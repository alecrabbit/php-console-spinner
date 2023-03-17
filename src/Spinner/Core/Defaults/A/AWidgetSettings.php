<?php

declare(strict_types=1);
// 15.03.23

namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;

abstract class AWidgetSettings extends ADefaultsChild implements IWidgetSettings
{
    protected static ?IFrame $leadingSpacer = null;
    protected static ?IFrame $trailingSpacer = null;
    protected static ?IPattern $charPattern = null;
    protected static ?IPattern $stylePattern = null;
    private static ?IWidgetSettings $widgetSettings = null;

    final protected function __construct(IDefaults $parent)
    {
        parent::__construct($parent);
        $this->reset();
    }

    protected function reset(): void
    {
        static::$charPattern = null;
        static::$stylePattern = null;
    }

    final public static function getInstance(IDefaults $parent): IWidgetSettings
    {
        if (null === self::$widgetSettings) {
            self::$widgetSettings =
                new class ($parent) extends AWidgetSettings {
                };
        }
        return self::$widgetSettings;
    }

    public function getLeadingSpacer(): IFrame
    {
        if (null === static::$leadingSpacer) {
            static::$leadingSpacer = FrameFactory::createEmpty();
        }
        return static::$leadingSpacer;
    }

    public function getTrailingSpacer(): IFrame
    {
        if (null === static::$trailingSpacer) {
            static::$trailingSpacer = FrameFactory::createSpace();
        }
        return static::$trailingSpacer;
    }

    public function setLeadingSpacer(IFrame $frame): static
    {
        static::$leadingSpacer = $frame;
        return $this;
    }

    public function setTrailingSpacer(IFrame $frame): static
    {
        static::$trailingSpacer = $frame;
        return $this;
    }

    public function getStylePattern(): ?IPattern
    {
        return static::$stylePattern;
    }

    public function getCharPattern(): ?IPattern
    {
        return static::$charPattern;
    }

    public function setStylePattern(IPattern $pattern): static
    {
        static::$stylePattern = $pattern;
        return $this;
    }

    public function setCharPattern(IPattern $pattern): static
    {
        static::$charPattern = $pattern;
        return $this;
    }
}
