<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\ISequencer;
use AlecRabbit\Spinner\Core\Contract\IWiggler;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;

final class Renderer implements Contract\IRenderer
{
    public function __construct(
        protected readonly ISequencer $sequencer
    ) {
    }

    public function renderFrame(IWigglerContainer $wigglers, null|float|int $interval = null): IFrame
    {
        $sequence = '';
        $width = 0;

        /** @var IWiggler $wiggler */
        foreach ($wigglers as $wiggler) {
            $frame = $wiggler->getFrame($interval);
            $sequence .= $this->sequencer->frameSequence($frame->sequence);
            $width += $frame->sequenceWidth;
        }

        return
            new Frame(
                $sequence,
                $width
            );
    }
}
