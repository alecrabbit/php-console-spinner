<?php

declare(strict_types=1);
// 24.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\A\AFrameRenderer;
use AlecRabbit\Spinner\Core\Contract\ICharFrameRenderer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final class CharFrameRenderer extends AFrameRenderer implements ICharFrameRenderer
{
    public function render(int|string|IStyle $entry): IFrame
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
        return $this->frameFactory->create($entry);
    }


    public function emptyFrame(): IFrame
    {
        return $this->frameFactory::createEmpty();
    }
}
