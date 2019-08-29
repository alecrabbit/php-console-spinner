<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;

/**
 * Class Styles
 *
 * @internal
 */
class Style
{
    /** @var Circular */
    protected $frameStyles;
    /** @var Circular */
    protected $messageStyles;
    /** @var Circular */
    protected $progressStyles;

    /**
     * Styles constructor.
     * @param array $styles
     * @param mixed $colorSupport
     */
    public function __construct(array $styles, $colorSupport = null)
    {
        $styles = $this->mergeStyles($styles);
        $coloring = new Coloring($styles, $colorSupport);
        $this->frameStyles = $coloring->getSpinnerStyles();
        $this->messageStyles = $coloring->getMessageStyles();
        $this->progressStyles = $coloring->getPercentStyles();
    }

    /**
     * @param array $styles
     * @return array
     */
    protected function mergeStyles(array $styles): array
    {
        $defaultStyles = StylesInterface::DEFAULT_STYLES;
        $keys = array_keys($defaultStyles);
        foreach ($keys as $key) {
            if (\array_key_exists($key, $styles)) {
                /** @noinspection SlowArrayOperationsInLoopInspection */
                $defaultStyles[$key] = array_merge(StylesInterface::DEFAULT_STYLES[$key], $styles[$key]);
            }
        }
        return $defaultStyles;
    }

    /**
     * @return Circular
     */
    public function getFrameStyles(): Circular
    {
        return $this->frameStyles;
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
    public function getProgressStyles(): Circular
    {
        return $this->progressStyles;
    }


}
