<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Jugglers;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\Coloring\Scott;
use AlecRabbit\Spinner\Core\Jugglers\Contracts\JugglerInterface;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;

abstract class AbstractJuggler implements JugglerInterface
{
    /** @var int */
    protected $currentFrameErasingLength;
    /** @var Circular */
    protected $style;
    /** @var string */
    protected $prefix = Defaults::EMPTY_STRING;
    /** @var string */
    protected $suffix = Defaults::EMPTY_STRING;
    /** @var int */
    protected $formatErasingShift;

    /** {@inheritDoc} */
    public function getFrameErasingLength(): int
    {
        return $this->currentFrameErasingLength;
    }

    /** {@inheritDoc} */
    public function getStyledFrame(): string
    {
        return
            sprintf((string)$this->style->value(), $this->getCurrentFrame());
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
    }

    /**
     * @return string
     */
    abstract protected function getCurrentFrame():string;
}
