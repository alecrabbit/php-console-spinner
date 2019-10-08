<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Coloring;

//use AlecRabbit\Cli\Tools\Terminal;
use AlecRabbit\Spinner\Core\Contracts\Juggler;
use AlecRabbit\Spinner\Core\Contracts\Styles;
use AlecRabbit\Spinner\Core\Sentinel;

use const AlecRabbit\NO_COLOR_TERMINAL;

class Colors
{
    /** @var Style */
    protected $frameStyles;
    /** @var Style */
    protected $messageStyles;
    /** @var Style */
    protected $progressStyles;
//    /** @var Terminal */
//    protected $terminal;

    /**
     * @param array $styles
     * @param int $color
     */
    public function __construct(array $styles, int $color = NO_COLOR_TERMINAL)
    {
        $styles = $this->mergeStyles($styles);
        Sentinel::assertStyles($styles, Styles::DEFAULT_STYLES);

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
