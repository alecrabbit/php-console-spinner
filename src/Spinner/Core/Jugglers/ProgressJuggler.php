<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Jugglers;

use AlecRabbit\Spinner\Core\Coloring\Scott;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use function AlecRabbit\Helpers\bounds;

class ProgressJuggler extends AbstractJuggler
{
    /** @var string */
    protected $spacer = Defaults::ONE_SPACE_SYMBOL;
    /** @var string */
    protected $currentFrame;

    public function __construct(float $percent, Scott $style)
    {
        $this->init($style);
        $this->update($percent);
    }

    /**
     * @param float $percent
     */
    protected function update(float $percent): void
    {
        $progress = bounds($percent, 0, 1);
        $this->currentFrame = $this->prefix . (int)($progress * 100) . '%' . $this->suffix . $this->spacer;
        $this->currentFrameErasingLength = strlen($this->currentFrame) + $this->formatErasingShift;
    }

    /**
     * @param float $percent
     */
    public function setProgress(float $percent): void
    {
        $this->update($percent);
    }

    /** {@inheritDoc} */
    protected function getCurrentFrame(): string
    {
        return $this->currentFrame;
    }
}
