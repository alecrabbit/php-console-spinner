<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Jugglers;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\Coloring\Scott;
use AlecRabbit\Spinner\Core\Style;
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
        $this->style = $style->getStyle();
        $this->update($percent);
    }

    /**
     * @param float $percent
     */
    protected function update(float $percent): void
    {
        $progress = bounds($percent, 0, 1);
        $this->currentFrame = $this->prefix . (int)($progress * 100) . '%' . $this->suffix . $this->spacer;
        $this->currentFrameErasingLength = strlen($this->currentFrame);
    }

    /**
     * @param float $percent
     */
    public function setProgress(float $percent): void
    {
        $this->update($percent);
    }

    /**
     * @return string
     */
    protected function getCurrentFrame(): string
    {
        return $this->currentFrame;
    }
}
