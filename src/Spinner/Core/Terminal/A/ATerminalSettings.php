<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Terminal\A;

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalSettings;

abstract class ATerminalSettings implements ITerminalSettings
{
    private static ?ITerminalSettings $instance = null;

    private function __construct(
        private ColorMode $colorMode,
        private int $width,
        private bool $hideCursor,
    ) {
    }

    final public static function getInstance(ColorMode $colorMode, int $width, bool $hideCursor,): self
    {
        if (null === self::$instance) {
            self::$instance =
                new class($colorMode, $width, $hideCursor) extends ATerminalSettings {
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
}