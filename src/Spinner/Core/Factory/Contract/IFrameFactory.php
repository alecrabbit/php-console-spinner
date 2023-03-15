<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\IFrame;

interface IFrameFactory
{
    public static function create(string $sequence, ?int $width = null): IFrame;

    public static function createEmpty(): IFrame;

    public static function createSpace(): IFrame;
}