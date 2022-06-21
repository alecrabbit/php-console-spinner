<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;
use AlecRabbit\Spinner\Kernel\Output\Contract\IOutput;

final class TwirlerRenderer implements IRenderer
{
    public function __construct(
        protected IOutput $output
    ) {
    }

    /**
     * @param ITwirler[] $twirlers
     */
    public function display(iterable $twirlers): int
    {
        $sequences = [];
        $width = 0;
        foreach ($twirlers as $twirler) {
            if ($twirler instanceof ITwirler) {
                $render = $twirler->render();
                $sequences[] = sprintf($render->getStyleFrame()->getSequenceStart(), $render->getCharFrame()->getChar());
                $width += $render->getCharFrame()->getWidth();
            }
        }
        $sequences[] = Sequencer::moveBackSequence($width);
        $this->output->write($sequences);
        return $width;
    }
}
