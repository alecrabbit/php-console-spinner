<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Frame\Factory\Contract;

use AlecRabbit\Spinner\Core\Frame\CharFrame;
use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;

abstract class ACharFrameFactory implements ICharFrameFactory
{
    public function create(string $char, int $width): ICharFrame
    {
        return
            new CharFrame(
                $char,
                $width
            );
    }
}
