<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\ConsoleColour\Terminal;

/**
 * Class Styling
 */
class Styling
{
    public const COLOR256_SPINNER_STYLES = '256_color_spinner_styles';
    public const COLOR_SPINNER_STYLES = 'color_spinner_styles';

    public const COLOR256_MESSAGE_STYLES = '256_color_message_styles';
    public const COLOR_MESSAGE_STYLES = 'color_message_styles';

    public const MAX_SYMBOLS_COUNT = 50;

    /** @var Circular */
    protected $styles;
    /** @var string */
    private $message;
    /** @var Circular */
    private $symbols;

    public function __construct(array $symbols, array $styles, string $message)
    {
        $this->assertSymbols($symbols);
        $this->assertStyles($styles);
        $this->symbols = new Circular($symbols);
        $this->styles = $this->makeStyles($styles);
        $this->message = $message;
    }

    protected function assertSymbols(array $symbols): void
    {
        if (self::MAX_SYMBOLS_COUNT < count($symbols)) {
            throw new \InvalidArgumentException('Symbols array is too big.');
        }
    }

    protected function assertStyles(array $styles): void
    {
        if (!\array_key_exists(self::COLOR256_SPINNER_STYLES, $styles)) {
            throw new \InvalidArgumentException($this->errorMsg('COLOR256_STYLES'));
        }
        if (!\array_key_exists(self::COLOR_SPINNER_STYLES, $styles)) {
            throw new \InvalidArgumentException($this->errorMsg('COLOR_STYLES'));
        }
    }

    /**
     * @param string $constant
     * @return string
     */
    private function errorMsg(string $constant): string
    {
        return 'Styles array does not have ' . static::class . '::' . $constant . 'key.';
    }

    /**
     * @param array $styles
     * @return Circular
     */
    protected function makeStyles(array $styles): Circular
    {
        if (($terminal = new Terminal())->supports256Color()) {
            return $this->circular256Color($styles);
        }
        if ($terminal->supportsColor()) {
            return $this->circularColor($styles);
        }
        return $this->circularNoColor();
    }

    protected function circular256Color(array $styles): Circular
    {
        if (null === $value = $styles[self::COLOR256_SPINNER_STYLES]) {
            return $this->circularColor($styles);
        }
        return
            new Circular(
                array_map(
                    static function (string $value): string {
                        return ConsoleColor::ESC_CHAR . "[38;5;{$value}m%s" . ConsoleColor::ESC_CHAR . '[0m';
                    },
                    $value
                )
            );
    }

    protected function circularColor(array $styles): Circular
    {
        if (null === $value = $styles[self::COLOR_SPINNER_STYLES]) {
            return $this->circularNoColor();
        }
        return
            new Circular(
                array_map(
                    static function (string $value): string {
                        return ConsoleColor::ESC_CHAR . "[{$value}m%s" . ConsoleColor::ESC_CHAR . '[0m';
                    },
                    $value
                )
            );
    }

    protected function circularNoColor(): Circular
    {
        return new Circular(['%s',]);
    }

    public function spinner(): string
    {
        return sprintf((string)$this->styles->value(), (string)$this->symbols->value());
    }

    public function message(string $message): string
    {
        return $message;
    }
}
