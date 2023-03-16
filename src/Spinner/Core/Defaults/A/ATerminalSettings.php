<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\ITerminalSettings;

abstract class ATerminalSettings extends ADefaultsChild implements ITerminalSettings
{
    private static ?ITerminalSettings $instance = null;

    final protected function __construct(
        IDefaults $parent,
        protected ColorMode $colorMode,
        protected int $width,
        protected bool $hideCursor,
    ) {
        parent::__construct($parent);
    }

    final public static function getInstance(
        IDefaults $parent,
        ColorMode $colorMode,
        int $width,
        bool $hideCursor,
    ): static {
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

    public function isHideCursor(): bool
    {
        return $this->hideCursor;
    }

    public function setHideCursor(bool $hideCursor): static
    {
        $this->hideCursor = $hideCursor;
        return $this;
    }

    public function toParent(): IDefaults
    {
        return $this->parent;
    }
}
