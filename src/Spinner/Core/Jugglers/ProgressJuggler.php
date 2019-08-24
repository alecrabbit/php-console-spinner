<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Jugglers;

use AlecRabbit\Spinner\Settings\Contracts\Defaults;

class ProgressJuggler
{
    /** @var float */
    protected $progress;
    /** @var string */
    protected $percentSpacer = Defaults::ONE_SPACE_SYMBOL;
    /** @var string */
    protected $currentFrame;

    public function __construct(float $percent)
    {
        $this->progress = $percent;
        $this->currentFrame = $this->percentSpacer . (int)($percent * 100) . '% ';
    }

    public function setProgress(float $percent): void
    {
        $this->progress = $percent;
    }

    public function getFrame(): string {
        return $this->currentFrame;
    }

    public function getFrameErasingLength(): int {
        return
            strlen($this->currentFrame);
    }
}