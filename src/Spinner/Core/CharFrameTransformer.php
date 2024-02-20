<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ICharFrameTransformer;
use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Exception\InvalidArgument;

final readonly class CharFrameTransformer implements ICharFrameTransformer
{
    public function transform(IFrame $frame): ICharSequenceFrame
    {
        if ($frame instanceof ICharSequenceFrame) {
            return $frame;
        }
        throw new InvalidArgument(
            sprintf(
                'Non-transformable frame type "%s".',
                get_class($frame),
            )
        );
    }
}
