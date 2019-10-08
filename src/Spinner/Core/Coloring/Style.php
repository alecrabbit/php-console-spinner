<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Coloring;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\Coloring\Contracts\StyleInterface;
use AlecRabbit\Spinner\Core\Contracts\Juggler;
use AlecRabbit\Spinner\Core\Contracts\Styles;
use AlecRabbit\Spinner\Core\Sentinel;

use const AlecRabbit\COLOR256_TERMINAL;
use const AlecRabbit\COLOR_TERMINAL;
use const AlecRabbit\ESC;
use const AlecRabbit\NO_COLOR_TERMINAL;
use const AlecRabbit\TRUECOLOR_TERMINAL;

class Style implements StyleInterface
{
    /** @var string */
    protected $format;
    /** @var string */
    protected $spacer;
    /** @var Circular */
    protected $style;

    public function __construct(array $styles, int $color)
    {
        Sentinel::assertStyles($styles, Styles::DEFAULT_STYLES_ELEMENT);
        $this->format = $styles[Juggler::FORMAT];
        $this->spacer = $styles[Juggler::SPACER];
        $this->style = $this->makeStyle($styles, $color);
    }

    /**
     * @param array $styles
     * @param int $color
     * @return Circular
     */
    protected function makeStyle(array $styles, int $color): Circular
    {
        $format = $this->makeFormat($this->format);
        switch ($color) {
            case TRUECOLOR_TERMINAL:
            case COLOR256_TERMINAL:
                return $this->circular256Color($styles, $format);
                break;
            case COLOR_TERMINAL:
                return $this->circularColor($styles, $format);
                break;
            default:
                return $this->circularNoColor($format);
                break;
        }
    }

    /**
     * @param array $styles
     * @param string $format
     * @return Circular
     */
    protected function circular256Color(array $styles, string $format): Circular
    {
        return
            Styles::DISABLED === $styles[Juggler::COLOR256] ?
                $this->circularColor($styles, $format) :
                new Circular(
                    array_map(
                        /**
                        * @param string|array $value
                        * @return string
                        */
                        static function ($value) use ($format): string {
                            if (\is_array($value)) {
                                [$fg, $bg] = $value;
                                return ESC . "[38;5;{$fg};48;5;{$bg}m" . $format . ESC . '[0m';
                            }
                            return ESC . "[38;5;{$value}m" . $format . ESC . '[0m';
                        },
                        $styles[Juggler::COLOR256]
                    )
                );
    }

    /**
     * @param array $styles
     * @param string $format
     * @return Circular
     */
    protected function circularColor(array $styles, string $format): Circular
    {
        return
            Styles::DISABLED === $styles[Juggler::COLOR] ?
                $this->circularNoColor($format) :
                new Circular(
                    array_map(
                        /**
                        * @param string|array $value
                        * @return string
                        */
                        static function ($value) use ($format): string {
                            if (\is_array($value)) {
                                $value = implode(';', $value);
                            }
                            return ESC . "[{$value}m" . $format . ESC . '[0m';
                        },
                        $styles[Juggler::COLOR]
                    )
                );
    }

    /**
     * @param string $format
     * @return Circular
     */
    protected function circularNoColor(string $format): Circular
    {

        return
            new Circular([$format,]);
    }

    /**
     * @param string $format
     * @return string
     */
    protected function makeFormat(string $format): string
    {
        return sprintf('%s', $format);
    }

    /** {@inheritDoc} */
    public function getStyle(): Circular
    {
        return $this->style;
    }

    /** {@inheritDoc} */
    public function getFormat(): string
    {
        return $this->format;
    }

    /** {@inheritDoc} */
    public function getSpacer(): string
    {
        return $this->spacer;
    }
}
