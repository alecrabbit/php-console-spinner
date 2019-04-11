<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\ConsoleColour\Terminal;
use AlecRabbit\Spinner\Contracts\StylesInterface;

/**
 * Class Styling
 *
 * @internal
 */
class Styles
{
    public const MAX_SYMBOLS_COUNT = 50;

    /** @var Circular */
    protected $symbolStyles;
    /** @var Circular */
    protected $messageStyles;
    /** @var Circular */
    protected $percentStyles;
    /** @var Circular */
    protected $symbols;

    public function __construct(array $styles)
    {
        $this->assertStyles($styles);
        $this->symbolStyles = $this->symbolStyles($styles);
        $this->messageStyles = $this->messageStyles($styles);
        $this->percentStyles = $this->percentStyles($styles);
    }

    protected function assertStyles(array $styles): void
    {
        if (!\array_key_exists(StylesInterface::COLOR256_SPINNER_STYLES, $styles)) {
            throw new \InvalidArgumentException(
                $this->errorMsg('Styles array does not have', 'COLOR256_STYLES')
            );
        }
        $value = $styles[StylesInterface::COLOR256_SPINNER_STYLES];
        if (!\is_array($value) && null !== $value) {
            throw new \InvalidArgumentException(
                $this->errorMsg('Styles should be type of array or NULL in', 'COLOR256_STYLES')
            );
        }
        if (!\array_key_exists(StylesInterface::COLOR_SPINNER_STYLES, $styles)) {
            throw new \InvalidArgumentException(
                $this->errorMsg('Styles array does not have', 'COLOR_STYLES')
            );
        }
        $value = $styles[StylesInterface::COLOR_SPINNER_STYLES];
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
        $value = $styles[StylesInterface::COLOR256_SPINNER_STYLES];
        /** @noinspection NotOptimalIfConditionsInspection */
        if (($terminal = new Terminal())->supports256Color() && null !== $value) {
            return $this->circular256Color($value);
        }

        $value = $styles[StylesInterface::COLOR_SPINNER_STYLES];
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

    /**
     * @param array $styles
     * @return Circular
     */
    protected function messageStyles(array $styles): Circular
    {
        if (!\array_key_exists(StylesInterface::COLOR_MESSAGE_STYLES, $styles)) {
            $styles[StylesInterface::COLOR_MESSAGE_STYLES] = StylesInterface::DEFAULT_MESSAGE_STYLES;
        }
        if ((new Terminal())->supportsColor()) {
            $value = $styles[StylesInterface::COLOR_MESSAGE_STYLES];
            if (null === $value) {
                return $this->circularNoColor();
            }
            return $this->circularColor($value);
        }
        return $this->circularNoColor();
    }

    /**
     * @param array $styles
     * @return Circular
     */
    protected function percentStyles(array $styles): Circular
    {
        if (!\array_key_exists(StylesInterface::COLOR_PERCENT_STYLES, $styles)) {
            $styles[StylesInterface::COLOR_PERCENT_STYLES] = StylesInterface::DEFAULT_PERCENT_STYLES;
        }
        if ((new Terminal())->supportsColor()) {
            $value = $styles[StylesInterface::COLOR_PERCENT_STYLES];
            if (null === $value) {
                return $this->circularNoColor();
            }
            return $this->circularColor($value);
        }
        return $this->circularNoColor();
    }

    public function spinner(string $symbol): string
    {
        return sprintf((string)$this->symbolStyles->value(), $symbol);
//        return sprintf((string)$this->symbolStyles->value(), (string)$this->symbols->value());
    }

    public function message(string $message): string
    {
        return
            sprintf(
                (string)$this->messageStyles->value(),
                $message
            );
    }

    public function percent(string $percent): string
    {
        return
            sprintf(
                (string)$this->percentStyles->value(),
                $percent
            );
    }
}
