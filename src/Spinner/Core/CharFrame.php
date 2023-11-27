<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\A\AFrame;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;

final readonly class CharFrame extends AFrame implements ICharFrame
{
    public static function createEmpty(): ICharFrame
    {
        return new CharFrame('', 0);
    }

    public static function createSpace(): ICharFrame
    {
        return new CharFrame(' ', 1);
    }
}
