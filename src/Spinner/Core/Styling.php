<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\ConsoleColour\Terminal;
use function AlecRabbit\typeOf;

/**
 * Class Styling
 */
class Styling
{
    public const COLOR256_SPINNER_STYLES = '256_color_spinner_styles';
    public const COLOR_SPINNER_STYLES = 'color_spinner_styles';

    public const COLOR_MESSAGE_STYLES = 'color_message_styles';
    public const DEFAULT_MESSAGE_STYLES = [2];

    public const MAX_SYMBOLS_COUNT = 50;

    /** @var Circular */
    protected $symbolStyles;
    /** @var Circular */
    protected $messageStyles;
    /** @var Circular */
    private $symbols;

    public function __construct(array $symbols, array $styles)
    {
        $this->assertSymbols($symbols);
        $this->assertStyles($styles);
        $this->symbols = new Circular($symbols);
        $this->symbolStyles = $this->symbolStyles($styles);
        $this->messageStyles = $this->messageStyles($styles);
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
            throw new \InvalidArgumentException(
                $this->errorMsg('Styles array does not have', 'COLOR256_STYLES')
            );
        }
        $value = $styles[self::COLOR256_SPINNER_STYLES];
        if (!\is_array($value) && null !== $value) {
            throw new \InvalidArgumentException(
                $this->errorMsg('Styles should be type of array or NULL in', 'COLOR256_STYLES')
            );
        }
        if (!\array_key_exists(self::COLOR_SPINNER_STYLES, $styles)) {
            throw new \InvalidArgumentException(
                $this->errorMsg('Styles array does not have', 'COLOR_STYLES')
            );
        }
        $value = $styles[self::COLOR_SPINNER_STYLES];
        if (!is_array($value) && null !== $value) {
            throw new \InvalidArgumentException(
                $this->errorMsg('Styles should be type of array or NULL in', 'COLOR_SPINNER_STYLES')
            );
        }
    }

    /**
     * @param string $str
     * @param string $constant
     * @return string
     */
    private function errorMsg(string $str, string $constant): string
    {
        return $str . ' ' . $constant . ' key.';
    }

    /**
     * @param array $styles
     * @return Circular
     */
    protected function symbolStyles(array $styles): Circular
    {
        $value = $styles[self::COLOR256_SPINNER_STYLES];
        /** @noinspection NotOptimalIfConditionsInspection */
        if (($terminal = new Terminal())->supports256Color() && null !== $value) {
            return $this->circular256Color($value);
        }

        $value = $styles[self::COLOR_SPINNER_STYLES];
        /** @noinspection NotOptimalIfConditionsInspection */
        if ($terminal->supportsColor() && null !== $value) {
            return $this->circularColor($value);
        }
        return $this->circularNoColor();
    }

    protected function circular256Color(array $styles): Circular
    {
        return
            new Circular(
                array_map(
                    static function (string $value): string {
                        return ConsoleColor::ESC_CHAR . "[38;5;{$value}m%s" . ConsoleColor::ESC_CHAR . '[0m';
                    },
                    $styles
                )
            );
    }

    protected function circularColor(array $styles): Circular
    {
        return
            new Circular(
                array_map(
                    static function (string $value): string {
                        return ConsoleColor::ESC_CHAR . "[{$value}m%s" . ConsoleColor::ESC_CHAR . '[0m';
                    },
                    $styles
                )
            );
    }

    protected function circularNoColor(): Circular
    {
        return new Circular(['%s',]);
    }

    public function spinner(): string
    {
        return sprintf((string)$this->symbolStyles->value(), (string)$this->symbols->value());
    }

    public function message(string $message): string
    {
        return
            sprintf(
                (string)$this->messageStyles->value(),
                $message
            );
//        return
//            sprintf(
//                ConsoleColor::ESC_CHAR . '[2m%s' . ConsoleColor::ESC_CHAR . '[0m',
//                $message
//            );
    }

    /**
     * @param array $styles
     * @return Circular
     */
    protected function messageStyles(array $styles): Circular
    {
        if (!\array_key_exists(self::COLOR_MESSAGE_STYLES, $styles)) {
            $styles[self::COLOR_MESSAGE_STYLES] = self::DEFAULT_MESSAGE_STYLES;
        }
        if ((new Terminal())->supportsColor()) {
            $value = $styles[self::COLOR_MESSAGE_STYLES];
            if (null === $value) {
                return $this->circularNoColor();
            }
            return $this->circularColor($value);
        }
        return $this->circularNoColor();
    }
}
