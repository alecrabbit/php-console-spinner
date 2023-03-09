<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Config\Defaults\A;

use AlecRabbit\Spinner\Config\Defaults\Contract\ITerminal;
use AlecRabbit\Spinner\Core\ColorMode;

abstract class ATerminal implements ITerminal
{
    private static ?ITerminal $instance = null;
    private ColorMode $colorMode;
    private int $width;

    private function __construct()
    {
        $this->colorMode = TerminalProbe::getColorMode();
        $this->width = TerminalProbe::getWidth();
    }

    public function getColorMode(): ColorMode
    {
        return $this->colorMode;
    }

    public function setColorMode(ColorMode $colorMode): void
    {
        $this->colorMode = $colorMode;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    final public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance =
                new class() extends ATerminal {
                };
        }
        return self::$instance;
    }
}