<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Contract\IHasStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\IStyleFrameTransformer;
use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Core\Contract\IUpdateChecker;

final class StylePaletteWrapper implements IHasStyleSequenceFrame
{
    private IStyleSequenceFrame $currentFrame;

    public function __construct(
        private readonly IHasFrame $frames,
        private readonly IStyleFrameTransformer $transformer,
        private readonly IUpdateChecker $updateChecker,
    ) {
        $this->currentFrame = $this->getFrame();
    }

    public function getFrame(?float $dt = null): IStyleSequenceFrame
    {
        if ($this->updateChecker->isDue($dt)) {
            $this->currentFrame = $this->nextFrame($dt);
        }
        return $this->currentFrame;
    }

    private function nextFrame(?float $dt = null): IStyleSequenceFrame
    {
        return $this->transformer->transform(
            $this->frames->getFrame($dt)
        );
    }
}
