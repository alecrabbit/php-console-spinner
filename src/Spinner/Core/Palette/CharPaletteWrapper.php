<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Contract\ICharFrameTransformer;
use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IHasCharSequenceFrame;
use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Core\Contract\IUpdateChecker;

final class CharPaletteWrapper implements IHasCharSequenceFrame
{
    private ICharSequenceFrame $currentFrame;

    public function __construct(
        private readonly IHasFrame $frames,
        private readonly ICharFrameTransformer $transformer,
        private readonly IUpdateChecker $updateChecker,
    ) {
        $this->currentFrame = $this->getFrame();
    }

    public function getFrame(?float $dt = null): ICharSequenceFrame
    {
        if ($this->updateChecker->isDue($dt)) {
            $this->currentFrame = $this->nextFrame($dt);
        }
        return $this->currentFrame;
    }

    private function nextFrame(?float $dt = null): ICharSequenceFrame
    {
        return $this->transformer->transform(
            $this->frames->getFrame($dt)
        );
    }
}
