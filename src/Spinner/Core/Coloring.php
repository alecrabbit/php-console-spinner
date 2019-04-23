<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Cli\Tools\Core\TerminalStatic;
use const AlecRabbit\COLOR256_TERMINAL;
use const AlecRabbit\COLOR_TERMINAL;
use const AlecRabbit\NO_COLOR_TERMINAL;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use const AlecRabbit\ESC;

class Coloring
{
    /** @var Circular */
    protected $spinnerStyles;
    /** @var Circular */
    protected $messageStyles;
    /** @var Circular */
    protected $percentStyles;

    /**
     * Prototype constructor.
     * @param array $styles
     * @param mixed $color
     */
    public function __construct(array $styles, $color = null)
    {
        $this->assertStyles($styles);
        // Styles defaults - NO color
        $this->spinnerStyles = $this->circularNoColor();
        $this->messageStyles = $this->circularNoColor();
        $this->percentStyles = $this->circularNoColor();
        // Reassign styles
        $this->assignStyles($styles, $this->refineColor($color));
    }

    /**
     * @param array $styles
     */
    protected function assertStyles(array $styles): void
    {
        foreach (StylesInterface::DEFAULT_STYLES as $key => $defaults) {
            if (!\array_key_exists($key, $styles)) {
                throw new \InvalidArgumentException(
                    'Styles array does not have [' . $key . '] key.'
                );
            }
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
     * @return Circular
     */
    protected function circularNoColor(): Circular
    {
        return new Circular(['%s',]);
    }

    /**
     * @param array $styles
     * @param mixed $color
     */
    protected function assignStyles(array $styles, $color): void
    {
        switch ($color) {
            case COLOR256_TERMINAL:
                $this->spinnerStyles = $this->circular256Color($styles[StylesInterface::SPINNER_STYLES]);
                $this->messageStyles = $this->circular256Color($styles[StylesInterface::MESSAGE_STYLES]);
                $this->percentStyles = $this->circular256Color($styles[StylesInterface::PERCENT_STYLES]);
                break;
            case COLOR_TERMINAL:
                $this->spinnerStyles = $this->circularColor($styles[StylesInterface::SPINNER_STYLES]);
                $this->messageStyles = $this->circularColor($styles[StylesInterface::MESSAGE_STYLES]);
                $this->percentStyles = $this->circularColor($styles[StylesInterface::PERCENT_STYLES]);
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
                            return ESC . "[38;5;{$value}m%s" . ESC . '[0m';
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
                            return ESC . "[{$value}m%s" . ESC . '[0m';
                        },
                        $styles[StylesInterface::COLOR]
                    )
                );
    }

    /**
     * @param null|int $color
     * @return int
     */
    protected function refineColor(?int $color): int
    {
        if (null === $color) {
            if (TerminalStatic::supportsColor()) {
                return
                    TerminalStatic::supports256Color() ?
                        COLOR256_TERMINAL :
                        COLOR_TERMINAL;
            }
            return NO_COLOR_TERMINAL;
        }
        return $color;
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
