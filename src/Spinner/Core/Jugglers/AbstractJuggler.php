<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Jugglers;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\Coloring\Scott;
use AlecRabbit\Spinner\Core\Jugglers\Contracts\JugglerInterface;
use AlecRabbit\Spinner\Core\Style;
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

    abstract protected function getCurrentFrame():string;
}
