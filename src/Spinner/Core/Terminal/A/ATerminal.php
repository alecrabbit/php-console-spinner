<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Terminal\A;

use AlecRabbit\Spinner\Core\ColorMode;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminal;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;
use AlecRabbit\Spinner\Core\Terminal\NativeTerminalProbe;

abstract class ATerminal implements ITerminal
{
    private static ?ITerminal $instance = null;

    private function __construct(
        private ColorMode $colorMode,
        private int $width,
        private bool $hideCursor,
    ) {
    }

    final public static function getInstance(iterable $terminalProbes): self
    {
        if (null === self::$instance) {
            $colorMode = NativeTerminalProbe::getColorMode();
            $width = NativeTerminalProbe::getWidth();
            $hideCursor = ITerminal::TERMINAL_DEFAULT_HIDE_CURSOR;

            /** @var ITerminalProbe $terminalProbe */
            foreach ($terminalProbes as $terminalProbe) {
                if ($terminalProbe::isSupported()) {
                    $colorMode = $terminalProbe::getColorMode();
                    $width = $terminalProbe::getWidth();
                }
            }

            self::$instance =
                new class($colorMode, $width, $hideCursor) extends ATerminal {
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