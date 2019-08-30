<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Coloring;

use AlecRabbit\Cli\Tools\Core\TerminalStatic;
use AlecRabbit\Spinner\Core\Contracts\Juggler;
use AlecRabbit\Spinner\Core\Contracts\Styles;
use const AlecRabbit\COLOR256_TERMINAL;
use const AlecRabbit\COLOR_TERMINAL;
use const AlecRabbit\NO_COLOR_TERMINAL;

class Tommy
{
    /** @var Scott */
    protected $frameStyles;
    /** @var Scott */
    protected $messageStyles;
    /** @var Scott */
    protected $progressStyles;

    /**
     * @param array $styles
     * @param int|null $color
     */
    public function __construct(array $styles, int $color = null)
    {
        $styles = $this->mergeStyles($styles);
        $this->assertStyles($styles);
        $color = $this->refineColor($color);
        $this->frameStyles = new Scott($styles[Juggler::FRAMES_STYLES], $color);
        $this->messageStyles = new Scott($styles[Juggler::MESSAGE_STYLES], $color);
        $this->progressStyles = new Scott($styles[Juggler::PROGRESS_STYLES], $color);
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
        $keys = array_keys(Styles::DEFAULT_STYLES);
        foreach ($keys as $index) {
            if (!\array_key_exists($index, $styles)) {
                // @codeCoverageIgnoreStart
                throw new \InvalidArgumentException(
                    'Styles array does not have [' . $index . '] key.'
                );
                // @codeCoverageIgnoreEnd
            }
        }
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
     * @return Scott
     */
    public function getFrameStyles(): Scott
    {
        return $this->frameStyles;
    }

    /**
     * @return Scott
     */
    public function getMessageStyles(): Scott
    {
        return $this->messageStyles;
    }

    /**
     * @return Scott
     */
    public function getProgressStyles(): Scott
    {
        return $this->progressStyles;
    }
}
