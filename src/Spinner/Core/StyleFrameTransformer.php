<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IStyleFrameTransformer;
use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Exception\InvalidArgument;

final readonly class StyleFrameTransformer implements IStyleFrameTransformer
{
    public function transform(IFrame $frame): IStyleSequenceFrame
    {
        if ($frame instanceof IStyleSequenceFrame) {
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
