<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;
use AlecRabbit\Spinner\Kernel\Output\Contract\IOutput;
use AlecRabbit\Spinner\Kernel\Sequencer;

final class TwirlerRenderer
{
    public function __construct(
        protected IOutput $output
    ) {
    }

    public function render(iterable $twirlers): void
    {
        $sequences = [];
        $width = 0;
        foreach ($twirlers as $twirler) {
            if ($twirler instanceof ITwirler) {
                $render = $twirler->render();
                $sequences[] = sprintf($render->getStyleFrame()->getSequence(), $render->getCharFrame()->getChar());
                $width += $render->getCharFrame()->getWidth();
            }
        }
        $sequences[] = Sequencer::moveBackSequence($width);

        $this->output->write($sequences);
    }
}
