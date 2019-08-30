<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\Contracts\StyleInterface;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;

class Style implements StyleInterface
{
    /** @var Circular */
    protected $styles;
    /** @var string */
    protected $format;
    /** @var string */
    protected $spacer;

    /**
     * Style constructor.
     * @param null|Circular $styles
     * @param null|string $format
     * @param string|null $spacer
     */
    public function __construct(?Circular $styles = null, ?string $format = null, string $spacer = null)
    {
        $this->styles = $styles ?? new Circular(['%s',]);
        $this->format = $format ?? Defaults::DEFAULT_FORMAT;
        $this->spacer = $spacer ?? Defaults::DEFAULT_SPACER;
    }

    /** {@inheritDoc} */
    public function getStyle(): Circular
    {
        return $this->styles;
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