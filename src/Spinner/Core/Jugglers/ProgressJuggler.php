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
    protected $percentSpacer = Defaults::ONE_SPACE_SYMBOL;
    /** @var string */
    protected $currentFrame;

    public function __construct(float $percent)
    {
        $this->update($percent);
    }

    public function setProgress(float $percent): void
    {
        $this->update($percent);
    }

    public function getFrame(): string
    {
        return $this->currentFrame;
    }

    public function getFrameErasingLength(): int
    {
        return
            strlen($this->currentFrame);
    }

    /**
     * @param float $percent
     */
    protected function update(float $percent): void
    {
        $this->progress = bounds($percent, 0, 1);
        $this->currentFrame = $this->percentSpacer . (int)($this->progress * 100) . '% ';
    }
}
