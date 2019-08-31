<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Jugglers;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\Coloring\Scott;
use AlecRabbit\Spinner\Core\Jugglers\Contracts\JugglerInterface;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;

abstract class AbstractJuggler implements JugglerInterface
{
    /** @var string */
    protected $spacer = Defaults::ONE_SPACE_SYMBOL;

    /** @var int */
    protected $currentFrameErasingLength;

    /**
     * @var Circular
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected $style;

    /** @var int */
    protected $formatErasingShift = 0;

    /** {@inheritDoc} */
    public function getFrameErasingLength(): int
    {
        return $this->currentFrameErasingLength;
    }

    /** {@inheritDoc} */
    public function getStyledFrame(): string
    {
        return
            sprintf((string)$this->style->value(), $this->getCurrentFrame()) . $this->spacer;
    }


    /**
     * @param string $format
     * @return int
     */
    protected function calcFormatErasingShift(string $format): int
    {
        return strlen(sprintf($format, ''));
    }

    /**
     * @param Scott $style
     */
    protected function init(Scott $style): void
    {
        $this->style = $style->getStyle();
        $this->formatErasingShift = $this->calcFormatErasingShift($style->getFormat());
        $this->spacer = $style->getSpacer();
    }

    /**
     * @return string
     */
    abstract protected function getCurrentFrame():string;
}
