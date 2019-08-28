<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Jugglers;

use AlecRabbit\Spinner\Core\Jugglers\Contracts\JugglerInterface;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use function AlecRabbit\Helpers\bounds;

class ProgressJuggler implements JugglerInterface
{
    /** @var float */
    protected $progress;
    /** @var string */
    protected $spacer = Defaults::ONE_SPACE_SYMBOL;
    /** @var string */
    protected $currentFrame;
    /** @var int */
    protected $currentFrameErasingLength;

    public function __construct(float $percent)
    {
        $this->update($percent);
    }

    /**
     * @param float $percent
     */
    protected function update(float $percent): void
    {
        $this->progress = bounds($percent, 0, 1);
        $this->currentFrame = (int)($this->progress * 100) . '%' . $this->spacer;
        $this->currentFrameErasingLength = strlen($this->currentFrame);
    }

    /**
     * @param float $percent
     */
    public function setProgress(float $percent): void
    {
        $this->update($percent);
    }

    /** {@inheritDoc} */
    public function getFrame(): string
    {
        return $this->currentFrame;
    }

    /** {@inheritDoc} */
    public function getFrameErasingLength(): int
    {
        return

            $this->currentFrameErasingLength;
    }
}
