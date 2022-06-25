<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Frame\Factory\Contract;

use AlecRabbit\Spinner\Core\Frame\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Frame\StyleFrame;
use AlecRabbit\Spinner\Core\Sequencer;

abstract class AStyleFrameFactory implements IStyleFrameFactory
{
    public function create(mixed $item, ?string $format): IStyleFrame
    {
        if ($item instanceof IStyleFrame) {
            return $item;
        }

        if (is_scalar($item)) {
            $item = [$item];
        }

        return
            new StyleFrame(
                Sequencer::colorSequenceStart(sprintf($format, ...$item)),
                Sequencer::colorSequenceEnd()
            );
    }
}
