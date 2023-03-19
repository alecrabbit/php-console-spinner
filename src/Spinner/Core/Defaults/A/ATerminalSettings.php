<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\ITerminalSettings;
use AlecRabbit\Spinner\Helper\Asserter;

abstract class ATerminalSettings extends ADefaultsChild implements ITerminalSettings
{
    protected static \Traversable $supportedColorModes;

    private static ?ITerminalSettings $instance = null;

    final protected function __construct(
        IDefaults $parent,
        protected ColorMode $colorMode,
        protected int $width,
        protected bool $hideCursor,
    ) {
        parent::__construct($parent);
        static::$supportedColorModes = $this->defaultSupportedColorModes();
    }

    final public static function getInstance(
        IDefaults $parent,
        ColorMode $colorMode,
        int $width,
        bool $hideCursor,
    ): ITerminalSettings {
        if (null === self::$instance) {
            self::$instance =
                new class ($parent, $colorMode, $width, $hideCursor) extends ATerminalSettings {
                };
        }
        return self::$instance;
    }

    public function getColorMode(): ColorMode
    {
        return $this->colorMode;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setColorMode(ColorMode $colorMode): static
    {
        $this->colorMode = $colorMode;
        return $this;
    }

    public function setWidth(int $width): static
    {
        $this->width = $width;
        return $this;
    }

    public function isCursorDisabled(): bool
    {
        return $this->hideCursor;
    }

    public function setHideCursor(bool $hideCursor): static
    {
        $this->hideCursor = $hideCursor;
        return $this;
    }

    public function getSupportedColorModes(): \Traversable
    {
        return static::$supportedColorModes;
    }

    /** @inheritdoc */
    public function overrideSupportedColorModes(\Traversable $supportedColorModes): static
    {
        Asserter::assertColorModes($supportedColorModes);
        static::$supportedColorModes = $supportedColorModes;
        return $this;
    }

    protected function defaultSupportedColorModes(): \ArrayObject
    {
        return new \ArrayObject(ColorMode::cases());
    }
}
