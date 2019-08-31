<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Coloring;

use AlecRabbit\Cli\Tools\Core\TerminalStatic;
use AlecRabbit\Cli\Tools\Terminal;
use AlecRabbit\Spinner\Core\Contracts\Juggler;
use AlecRabbit\Spinner\Core\Contracts\Styles;
use const AlecRabbit\COLOR256_TERMINAL;
use const AlecRabbit\COLOR_TERMINAL;
use const AlecRabbit\NO_COLOR_TERMINAL;

class Colors
{
    /** @var Style */
    protected $frameStyles;
    /** @var Style */
    protected $messageStyles;
    /** @var Style */
    protected $progressStyles;
    /** @var Terminal */
    protected $terminal;

    /**
     * @param array $styles
     * @param int|null $color
     */
    public function __construct(array $styles, int $color = null)
    {
        $styles = $this->mergeStyles($styles);
        $this->assertStyles($styles); // Left here for now
        $this->terminal = new Terminal(null, null, $color);

        $color = $this->terminal->color();

        $this->frameStyles = new Style($styles[Juggler::FRAMES_STYLES], $color);
        $this->messageStyles = new Style($styles[Juggler::MESSAGE_STYLES], $color);
        $this->progressStyles = new Style($styles[Juggler::PROGRESS_STYLES], $color);
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
     * @return Style
     */
    public function getFrameStyles(): Style
    {
        return $this->frameStyles;
    }

    /**
     * @return Style
     */
    public function getMessageStyles(): Style
    {
        return $this->messageStyles;
    }

    /**
     * @return Style
     */
    public function getProgressStyles(): Style
    {
        return $this->progressStyles;
    }
}
