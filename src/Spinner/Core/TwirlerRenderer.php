<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\C;
use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Frame\CharFrame;
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
        $spacer = new CharFrame(C::SPACE_CHAR, 1);
        foreach ($twirlers as $twirler) {
            if ($twirler instanceof ITwirler) {
                $render = $twirler->render();
                $sequences[] = $render->getStyleFrame()->getSequenceStart();
                $sequences[] = $render->getCharFrame()->getChar();
                $sequences[] = $render->getStyleFrame()->getSequenceEnd();
                $width += $render->getCharFrame()->getWidth();
//                $sequences[] = $spacer->getChar();
//                $width += $spacer->getWidth();
            }
        }
        $sequences[] = Sequencer::moveBackSequence($width);
        $this->output->write($sequences);
        return $width;
    }
}
