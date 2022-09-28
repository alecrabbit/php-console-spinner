<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Contract;

use AlecRabbit\Spinner\Core\Frame\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Interval\Contract\HasInterval;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IStyleFrameCollection extends ICollection, HasInterval
{
    /**
     * @throws InvalidArgumentException
     */
    public static function create(array $frames, IInterval $interval): IStyleFrameCollection;

    public function next(): IStyleFrame;
}