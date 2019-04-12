<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\ConsoleColour\Terminal;
use AlecRabbit\Spinner\Contracts\SettingsInterface;
use AlecRabbit\Spinner\Contracts\StylesInterface;

class Prototype
{
    /** @var Circular */
    protected $spinnerStyles;
    /** @var Circular */
    protected $messageStyles;
    /** @var Circular */
    protected $percentStyles;
    /** @var Terminal */
    protected $terminal;
    /** @var int */
    protected $color;

    /**
     * Prototype constructor.
     * @param array $styles
     */
    public function __construct(array $styles)
    {
        $this->assertStyles($styles);
        $this->terminal = new Terminal();
        if ($this->terminal->supportsColor()) {
            $this->color =
                $this->terminal->supports256Color() ?
                    StylesInterface::COLOR256 :
                    StylesInterface::COLOR;
        } else {
            $this->color = StylesInterface::NO_COLOR;
        }
        $this->styles($styles);
    }

    /**
     * @param array $styles
     */
    protected function assertStyles(array $styles): void
    {
//        dump($styles);
        foreach (StylesInterface::DEFAULT_STYLES as $key => $defaults) {
            if (!\array_key_exists($key, $styles)) {
                throw new \InvalidArgumentException(
                    'Styles array does not have [' . $key . '] key.'
                );
            }
//            dump($defaults,  $styles[$key]);
            foreach ($defaults as $k => $value) {
                if (!\array_key_exists($k, $styles[$key])) {
                    throw new \InvalidArgumentException(
                        'Styles array does not have [' . $key . '][' . $k . '] key.'
                    );
                }
            }
        }
    }

    /**
     * @param array $styles
     */
    protected function styles(array $styles): void
    {
        switch ($this->color) {
            case StylesInterface::COLOR256:
                $this->spinnerStyles = $this->circular256Color($styles[StylesInterface::SPINNER_STYLES]);
                $this->messageStyles = $this->circular256Color($styles[StylesInterface::MESSAGE_STYLES]);
                $this->percentStyles = $this->circular256Color($styles[StylesInterface::PERCENT_STYLES]);
                break;
            case StylesInterface::COLOR:
                $this->spinnerStyles = $this->circularColor($styles[StylesInterface::SPINNER_STYLES]);
                $this->messageStyles = $this->circularColor($styles[StylesInterface::MESSAGE_STYLES]);
                $this->percentStyles = $this->circularColor($styles[StylesInterface::PERCENT_STYLES]);
                break;
            case StylesInterface::NO_COLOR:
                $this->spinnerStyles = $this->circularNoColor();
                $this->messageStyles = $this->circularNoColor();
                $this->percentStyles = $this->circularNoColor();
                break;
        }
    }

    /**
     * @param array $styles
     * @return Circular
     */
    protected function circular256Color(array $styles): Circular
    {
        return
            StylesInterface::DISABLED === $styles[StylesInterface::COLOR256] ?
                $this->circularColor($styles) :
                new Circular(
                    array_map(
                        static function (string $value): string {
                            return ConsoleColor::ESC_CHAR . "[38;5;{$value}m%s" . ConsoleColor::ESC_CHAR . '[0m';
                        },
                        $styles[StylesInterface::COLOR256]
                    )
                );
    }

    /**
     * @param array $styles
     * @return Circular
     */
    protected function circularColor(array $styles): Circular
    {
        return
            StylesInterface::DISABLED === $styles[StylesInterface::COLOR] ?
                $this->circularNoColor() :
                new Circular(
                    array_map(
                        static function (string $value): string {
                            return ConsoleColor::ESC_CHAR . "[{$value}m%s" . ConsoleColor::ESC_CHAR . '[0m';
                        },
                        $styles[StylesInterface::COLOR]
                    )
                );
    }

    /**
     * @return Circular
     */
    protected function circularNoColor(): Circular
    {
        return new Circular(['%s',]);
    }

    /**
     * @return Circular
     */
    public function getSpinnerStyles(): Circular
    {
        return $this->spinnerStyles;
    }

    /**
     * @return Circular
     */
    public function getMessageStyles(): Circular
    {
        return $this->messageStyles;
    }

    /**
     * @return Circular
     */
    public function getPercentStyles(): Circular
    {
        return $this->percentStyles;
    }


}