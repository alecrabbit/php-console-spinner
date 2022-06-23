<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler;

use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Output\Contract\IOutput;
use AlecRabbit\Spinner\Core\Sequencer;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;

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
        // FIXME (2022-06-23 13:50) [Alec Rabbit]: refactor this method [2a3f2116-ddf7-4147-ac73-fd0d0fc6823f]
        $sequences = [];
        $width = 0;
//        $spacer = new CharFrame(C::SPACE_CHAR, 1);
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
