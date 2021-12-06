<?php

declare(strict_types=1);

namespace AlecRabbit\SpinnerOld\Core\Jugglers;

use AlecRabbit\SpinnerOld\Core\Circular;
use AlecRabbit\SpinnerOld\Core\Coloring\Style;
use AlecRabbit\SpinnerOld\Core\Jugglers\Contracts\JugglerInterface;
use AlecRabbit\SpinnerOld\Settings\Contracts\Defaults;
use AlecRabbit\SpinnerOld\Settings\Settings;

use function AlecRabbit\Helpers\wcswidth;

abstract class AbstractJuggler implements JugglerInterface
{
    /** @var string */
    protected $spacer = Defaults::ONE_SPACE_SYMBOL;
    /**
     * @var int
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected $currentFrameErasingWidth;
    /**
     * @var Circular
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected $style;
    /** @var int */
    protected $formatErasingWidthShift = 0;

    /**
     * @param Settings $settings
     * @param Style $style
     */
    abstract public function __construct(Settings $settings, Style $style);

    /** {@inheritDoc} */
    public function getFrameErasingWidth(): int
    {
        return $this->currentFrameErasingWidth;
    }

    /** {@inheritDoc} */
    public function getStyledFrame(): string
    {
        return
            sprintf((string)$this->style->value(), $this->getCurrentFrame()) . $this->spacer;
    }

    /**
     * @return string
     */
    abstract protected function getCurrentFrame(): string;

    /**
     * @param Style $style
     */
    protected function init(Style $style): void
    {
        $this->style = $style->getStyle();
        $this->formatErasingWidthShift = $this->computeFormatErasingWidthShift($style->getFormat());
        $this->spacer = $style->getSpacer();
    }

    /**
     * @param string $format
     * @return int
     */
    protected function computeFormatErasingWidthShift(string $format): int
    {
        return wcswidth(sprintf($format, ''));
    }
}
