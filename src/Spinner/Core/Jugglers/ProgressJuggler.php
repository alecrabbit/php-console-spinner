<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Jugglers;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\Jugglers\Contracts\JugglerInterface;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use function AlecRabbit\Helpers\bounds;

class ProgressJuggler implements JugglerInterface
{
    /** @var string */
    protected $spacer = Defaults::ONE_SPACE_SYMBOL;
    /** @var string */
    protected $currentFrame;
    /** @var int */
    protected $currentFrameErasingLength;
    /** @var Circular */
    protected $style;

    public function __construct(float $percent, Circular $style = null)
    {
        $this->style = $style ?? new Circular(['%s',]);
        $this->update($percent);
    }

    /**
     * @param float $percent
     */
    protected function update(float $percent): void
    {
        $progress = bounds($percent, 0, 1);
        $this->currentFrame = (int)($progress * 100) . '%' . $this->spacer;
        $this->currentFrameErasingLength = strlen($this->currentFrame);
    }

    /**
     * @param float $percent
     */
    public function setProgress(float $percent): void
    {
        $this->update($percent);
    }

//    /** {@inheritDoc} */
//    public function getFrame(): string
//    {
//        return $this->currentFrame;
//    }
//
    /** {@inheritDoc} */
    public function getStyledFrame(): string
    {
        return
            sprintf((string)$this->style->value(), $this->currentFrame);
    }

    /** {@inheritDoc} */
    public function getFrameErasingLength(): int
    {
        return

            $this->currentFrameErasingLength;
    }
}
