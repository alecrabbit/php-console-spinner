<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Jugglers;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\Jugglers\Contracts\JugglerInterface;

abstract class AbstractJuggler implements JugglerInterface
{
    /** @var int */
    protected $currentFrameErasingLength;
    /** @var Circular */
    protected $style;

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
