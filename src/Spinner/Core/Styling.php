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
    public const COLOR256_STYLES = '256_color_styles';
    public const COLOR_STYLES = 'color_styles';

    /** @var Circular */
    protected $styles;
    /** @var string */
    private $message;
    /** @var Circular */
    private $symbols;

    public function __construct(Circular $symbols, array $styles, string $message)
    {
        $this->symbols = $symbols;
        $this->message = $message;
        $this->assertStyles($styles);
        $this->styles = $this->makeStyles($styles);
    }

    protected function assertStyles(array $styles): void
    {
        if (!\array_key_exists(self::COLOR256_STYLES, $styles)) {
            throw new \InvalidArgumentException($this->errorMsg('COLOR256_STYLES'));
        }
        if (!\array_key_exists(self::COLOR_STYLES, $styles)) {
            throw new \InvalidArgumentException($this->errorMsg('COLOR_STYLES'));
        }
    }

    /**
     * @param string $constant
     * @return string
     */
    private function errorMsg(string $constant): string
    {
        return 'Styles array does not have ' . static::class . '::' . $constant . 'key';
    }

    /**
     * @param array $styles
     * @return Circular
     */
    protected function makeStyles(array $styles): Circular
    {
        $terminal = new Terminal();
        if ($terminal->supports256Color()) {
            return $this->circular256Color($styles);
        }
        if ($terminal->supportsColor()) {
            return $this->circularColor($styles);
        }
        return $this->circularNoColor();
    }

    protected function circular256Color(array $styles): Circular
    {
        if (null === $value = $styles[self::COLOR256_STYLES]) {
            return $this->circularColor($styles);
        }
        return
            new Circular(
                array_map(
                    static function ($value) {
                        return ConsoleColor::ESC_CHAR . "[38;5;{$value}m%s" . ConsoleColor::ESC_CHAR . '[0m';
                    },
                    $value
                )
            );
    }

    protected function circularNoColor(): Circular
    {
        return new Circular(['%s',]);
    }

    protected function circularColor(array $styles): Circular
    {
        if (null === $value = $styles[self::COLOR_STYLES]) {
            return $this->circularNoColor();
        }
        return
            new Circular(
                array_map(
                    static function ($value) {
                        return ConsoleColor::ESC_CHAR . "[{$value}m%s" . ConsoleColor::ESC_CHAR . '[0m';
                    },
                    $value
                )
            );
    }

    public function spinner(): string
    {
        return sprintf((string)$this->styles->value(), (string)$this->symbols->value());
    }

    public function message(): string
    {
        return $this->message;
    }

}