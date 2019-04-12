<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Circular;

/**
 * Class Styling
 *
 * @internal
 */
class Style
{
    /** @var Circular */
    protected $symbolStyles;
    /** @var Circular */
    protected $messageStyles;
    /** @var Circular */
    protected $percentStyles;

    /**
     * Styles constructor.
     * @param array $styles
     * @param mixed $color
     */
    public function __construct(array $styles, $color = null)
    {
        $prototype = new Prototype($styles, $color);
        $this->symbolStyles = $prototype->getSpinnerStyles();
        $this->messageStyles = $prototype->getMessageStyles();
        $this->percentStyles = $prototype->getPercentStyles();
    }

    public function spinner(string $symbol): string
    {
        return sprintf((string)$this->symbolStyles->value(), $symbol);
    }

    public function message(string $message): string
    {
        return
            sprintf(
                (string)$this->messageStyles->value(),
                $message
            );
    }

    public function percent(string $percent): string
    {
        return
            sprintf(
                (string)$this->percentStyles->value(),
                $percent
            );
    }
}
