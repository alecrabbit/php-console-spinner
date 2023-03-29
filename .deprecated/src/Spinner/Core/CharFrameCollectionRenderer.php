<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IStyle;
use AlecRabbit\Spinner\Core\A\AFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Factory\StaticFrameFactory;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

use function is_string;

final class CharFrameCollectionRenderer extends AFrameCollectionRenderer
{
    protected function createFrame(string|IStyle $entry): IFrame
    {
        if (!is_string($entry)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Entry should be type of "string", "%s" given%s.',
                    get_debug_type($entry),
                    sprintf(', see "%s()"', __METHOD__),
                )
            );
        }
        return StaticFrameFactory::create($entry, WidthDeterminer::determine($entry));
    }
}
