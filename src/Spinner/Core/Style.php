<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Circular;

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
        $coloring = new Coloring($styles, $colorSupport);
        $this->spinnerStyles = $coloring->getSpinnerStyles();
        $this->messageStyles = $coloring->getMessageStyles();
        $this->percentStyles = $coloring->getPercentStyles();
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
