<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\Contracts\StyleInterface;

class Style implements StyleInterface
{
    /** @var Circular */
    protected $styles;

    public function __construct(Circular $styles)
    {
        $this->styles = $styles;
    }

    /**
     * @return Circular
     */
    public function getStyle(): Circular
    {
        return $this->styles;
    }

    /**
     * @param Circular $styles
     * @return Style
     */
    public function setStyles(Circular $styles): Style
    {
        $this->styles = $styles;
        return $this;
    }

}