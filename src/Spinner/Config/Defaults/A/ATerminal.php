<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Config\Defaults\A;

use AlecRabbit\Spinner\Config\Defaults\Contract\ITerminal;
use AlecRabbit\Spinner\Core\Terminal\ColorMode;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;

abstract class ATerminal implements ITerminal
{
    private static ?ITerminal $instance = null;
    private bool $hideCursor;
    private ColorMode $colorMode;
    private int $width;

    private function __construct(iterable $terminalProbes)
    {
        /** @var ITerminalProbe $terminalProbe */
        foreach ($terminalProbes as $terminalProbe) {
            if ($terminalProbe::isSupported()) {
                $this->colorMode = $terminalProbe::getColorMode();
                $this->width = $terminalProbe::getWidth();
                return;
            }
        }
        $this->colorMode = ITerminal::TERMINAL_DEFAULT_COLOR_SUPPORT;
        $this->width = ITerminal::TERMINAL_DEFAULT_WIDTH;
        $this->hideCursor = ITerminal::TERMINAL_DEFAULT_HIDE_CURSOR;
    }

    public function getColorMode(): ColorMode
    {
        return $this->colorMode;
    }

    public function setColorMode(ColorMode $colorMode): static
    {
        $this->colorMode = $colorMode;
        return $this;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): static
    {
        $this->width = $width;
        return $this;
    }

    final public static function getInstance(iterable $terminalProbes): self
    {
        if (null === self::$instance) {
            self::$instance =
                new class($terminalProbes) extends ATerminal {
                };
        }
        return self::$instance;
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