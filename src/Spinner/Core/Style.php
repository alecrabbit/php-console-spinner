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
    protected $spinnerStyles;
    /** @var Circular */
    protected $messageStyles;
    /** @var Circular */
    protected $percentStyles;

    /**
     * Styles constructor.
     * @param array $styles
     * @param mixed $colorSupport
     */
    public function __construct(array $styles, $colorSupport = null)
    {
        dump('TO MERGE',$styles);
        $styles = $this->mergeStyles($styles);
        dump('************RESULT***********',$styles);
        $coloring = new Coloring($styles, $colorSupport);
        $this->spinnerStyles = $coloring->getSpinnerStyles();
        $this->messageStyles = $coloring->getMessageStyles();
        $this->percentStyles = $coloring->getPercentStyles();
    }

    /**
     * @param array $styles
     * @return array
     */
    protected function mergeStyles(array $styles): array
    {
        $defaultStyles = StylesInterface::DEFAULT_STYLES;
        foreach ($defaultStyles as $key => $defaults) {
            if (\array_key_exists($key, $styles)) {
                /** @noinspection SlowArrayOperationsInLoopInspection */
                $defaultStyles[$key] = array_merge(StylesInterface::DEFAULT_STYLES[$key], $styles[$key]);
            }
        }
        return $defaultStyles;
    }

    public function spinner(string $symbol): string
    {
        return
            sprintf((string)$this->spinnerStyles->value(), $symbol);
    }

    public function message(string $message): string
    {
        return
            sprintf((string)$this->messageStyles->value(), $message);
    }

    public function percent(string $percent): string
    {
        return
            sprintf((string)$this->percentStyles->value(), $percent);
    }
}
