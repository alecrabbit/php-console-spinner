<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Contract;

use AlecRabbit\Spinner\Core\Contract\IIntervalComponent;
use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\RuntimeException;

interface ICharFrameCollection extends ICollection,
                                       IIntervalComponent
{
    /**
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public static function create(array $frames, IInterval $interval): ICharFrameCollection;

    public function next(): ICharFrame;
}
