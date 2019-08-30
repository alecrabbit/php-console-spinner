<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Cli\Tools\Core\TerminalStatic;
use AlecRabbit\Spinner\Core\Contracts\Juggler;
use AlecRabbit\Spinner\Core\Contracts\Styles;
use const AlecRabbit\COLOR256_TERMINAL;
use const AlecRabbit\COLOR_TERMINAL;
use const AlecRabbit\ESC;
use const AlecRabbit\NO_COLOR_TERMINAL;

/**
 * Class Coloring
 * @internal
 */
class Coloring
{
    /** @var Circular */
    protected $frameStyles;
    /** @var Circular */
    protected $messageStyles;
    /** @var Circular */
    protected $progressStyles;

    /**
     * Coloring constructor.
     * @param array $styles
     * @param mixed $color
     */
    public function __construct(array $styles, $color = null)
    {
        $styles = $this->mergeStyles($styles);
        $this->assertStyles($styles);
        // Styles defaults - NO color
        $this->frameStyles = $this->circularNoColor();
        $this->messageStyles = $this->circularNoColor();
        $this->progressStyles = $this->circularNoColor();
        // Reassign styles
        $this->assignStyles($styles, $this->refineColor($color));
    }

    /**
     * @param array $styles
     * @return array
     */
    protected function mergeStyles(array $styles): array
    {
        $defaultStyles = Styles::DEFAULT_STYLES;
        $keys = array_keys($defaultStyles);
        foreach ($keys as $key) {
            if (\array_key_exists($key, $styles)) {
                /** @noinspection SlowArrayOperationsInLoopInspection */
                $defaultStyles[$key] = array_merge(Styles::DEFAULT_STYLES[$key], $styles[$key]);
            }
        }
        return $defaultStyles;
    }

    /**
     * @param array $styles
     */
    protected function assertStyles(array $styles): void
    {
        foreach (Styles::DEFAULT_STYLES as $index => $defaults) {
            if (!\array_key_exists($index, $styles)) {
                // @codeCoverageIgnoreStart
                throw new \InvalidArgumentException(
                    'Styles array does not have [' . $index . '] key.'
                );
                // @codeCoverageIgnoreEnd
            }
            $keys = array_keys($defaults);
            foreach ($keys as $k) {
                if (!\array_key_exists($k, $styles[$index])) {
                    // @codeCoverageIgnoreStart
                    throw new \InvalidArgumentException(
                        'Styles array does not have [' . $index . '][' . $k . '] key.'
                    );
                    // @codeCoverageIgnoreEnd
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
     * @param int $color
     */
    protected function assignStyles(array $styles, int $color): void
    {
        switch ($color) {
            case COLOR256_TERMINAL:
                $this->frameStyles = $this->circular256Color($styles[Juggler::FRAMES_STYLES]);
                $this->messageStyles = $this->circular256Color($styles[Juggler::MESSAGE_STYLES]);
                $this->progressStyles = $this->circular256Color($styles[Juggler::PROGRESS_STYLES]);
                break;
            case COLOR_TERMINAL:
                $this->frameStyles = $this->circularColor($styles[Juggler::FRAMES_STYLES]);
                $this->messageStyles = $this->circularColor($styles[Juggler::MESSAGE_STYLES]);
                $this->progressStyles = $this->circularColor($styles[Juggler::PROGRESS_STYLES]);
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
            Styles::DISABLED === $styles[Juggler::COLOR256] ?
                $this->circularColor($styles) :
                new Circular(
                    array_map(
                    /**
                     * @param string|array $value
                     * @return string
                     */
                        static function ($value): string {
                            if (\is_array($value)) {
                                [$fg, $bg] = $value;
                                return ESC . "[38;5;{$fg};48;5;{$bg}m%s" . ESC . '[0m';
                            }
                            return ESC . "[38;5;{$value}m%s" . ESC . '[0m';
                        },
                        $styles[Juggler::COLOR256]
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
            Styles::DISABLED === $styles[Juggler::COLOR] ?
                $this->circularNoColor() :
                new Circular(
                    array_map(
                    /**
                     * @param string|array $value
                     * @return string
                     */
                        static function ($value): string {
                            if (\is_array($value)) {
                                $value = implode(';', $value);
                            }
                            return ESC . "[{$value}m%s" . ESC . '[0m';
                        },
                        $styles[Juggler::COLOR]
                    )
                );
    }

    /**
     * @param null|int $color
     * @return int
     */
    protected function refineColor(?int $color): int
    {
        // @codeCoverageIgnoreStart
        if (null === $color) {
            if (TerminalStatic::supportsColor()) {
                return
                    TerminalStatic::supports256Color() ?
                        COLOR256_TERMINAL :
                        COLOR_TERMINAL;
            }
            return NO_COLOR_TERMINAL;
        }
        // @codeCoverageIgnoreEnd
        return $color;
    }

    /**
     * @return Style
     */
    public function getFrameStyles(): Style
    {
        return new Style($this->frameStyles);
    }

    /**
     * @return Style
     */
    public function getMessageStyles(): Style
    {
        return new Style($this->messageStyles);
    }

    /**
     * @return Style
     */
    public function getProgressStyles(): Style
    {
        return new Style($this->progressStyles);
    }

    protected function styleFactory(array $styles, int $color): Style
    {
//        $styles1 = $styles[Juggler::FRAMES_STYLES];
        switch ($color) {
            case COLOR256_TERMINAL:
                return new Style($this->circular256Color($styles));
                break;
            case COLOR_TERMINAL:
                return new Style($this->circularColor($styles));
                break;
            default:
                return new Style($this->circularNoColor());
                break;
        }

    }
}
