<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Frame\Factory\Contract;

use AlecRabbit\Spinner\Core\Frame\CharFrame;
use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\WidthDefiner;

abstract class ACharFrameFactory implements ICharFrameFactory
{
    public function create(string $char, ?int $width = null): ICharFrame
    {
        return
            new CharFrame(
                $char,
                $width ?? WidthDefiner::define($char)
            );
    }
}
