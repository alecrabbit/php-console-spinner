<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Factory\Contract;

use AlecRabbit\Spinner\Core\Collection\Contract\IStyleFrameCollection;

interface IStyleFrameCollectionFactory
{
    public function create(): IStyleFrameCollection;
}
