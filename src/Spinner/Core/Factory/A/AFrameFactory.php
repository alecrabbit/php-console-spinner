<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\WidthDeterminer;

abstract class AFrameFactory implements IFrameFactory
{
    public static function create(string $sequence, ?int $width = null): IFrame
    {
        return
            new Frame(
                $sequence,
                $width ?? WidthDeterminer::determine($sequence)
            );
    }

    public static function createEmpty(): IFrame
    {
        return new Frame('', 0);
    }

    public static function createSpace(): IFrame
    {
        return new Frame(' ', 1);
    }
}