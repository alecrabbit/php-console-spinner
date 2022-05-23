<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IWiggler;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;

final class Renderer implements Contract\IRenderer
{
    public function renderFrame(IWigglerContainer $container, null|float|int $interval = null): IFrame
    {
        $sequence = '';
        $width = 0;

        /** @var IWiggler $wiggler */
        foreach ($container->getWigglers() as $wiggler) {
            $sequence .= $wiggler->getSequence($interval);
            $width += $wiggler->getWidth();
        }

        return
            new Frame(
                $sequence,
                $width
            );
    }
}
