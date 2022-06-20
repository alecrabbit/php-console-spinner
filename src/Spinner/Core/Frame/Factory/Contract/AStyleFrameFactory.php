<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Frame\Factory\Contract;

use AlecRabbit\Spinner\Core\Frame\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Frame\StyleFrame;

abstract class AStyleFrameFactory implements IStyleFrameFactory
{
    public function create(string $sequence = null): IStyleFrame
    {
        return
            new StyleFrame($sequence ?? '%s');
    }
}
