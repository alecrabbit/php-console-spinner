<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\ConsoleColour\Terminal;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;

class Prototype
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
     * @param null|string $color
     * @return string
     */
    protected function refineColor(?string $color): string
    {
        if (null === $color) {
            $terminal = new Terminal();
            if ($terminal->supportsColor()) {
                return
                    $terminal->supports256Color() ?
                        StylesInterface::COLOR256 :
                        StylesInterface::COLOR;
            }
            return StylesInterface::NO_COLOR;
        }
        return $color;
    }

    /**
     * @param array $styles
     * @param mixed $color
     */
    protected function assignStyles(array $styles, $color): void
    {
        switch ($color) {
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
