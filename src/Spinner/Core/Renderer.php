<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IWiggler;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;

final class Renderer implements Contract\IRenderer
{
    public function __construct()
    {
    }

    public function renderFrame(IWigglerContainer $wigglers, ?IInterval $interval = null): IFrame
    {
        $sequence = '';
        $width = 0;

        /** @var IWiggler $wiggler */
        foreach ($wigglers as $wiggler) {
            $frame = $wiggler->createFrame($interval);
            $sequence .= $frame->sequence;
            $width += $frame->sequenceWidth;
        }

        return
            new Frame(
                $sequence,
                $width
            );
    }
}
