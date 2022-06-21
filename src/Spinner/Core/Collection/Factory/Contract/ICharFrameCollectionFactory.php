<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Factory\Contract;

use AlecRabbit\Spinner\Core\Collection\Contract\ICharFrameCollection;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;

interface ICharFrameCollectionFactory
{

    public function create(array $frames, IInterval $interval): ICharFrameCollection;
}
