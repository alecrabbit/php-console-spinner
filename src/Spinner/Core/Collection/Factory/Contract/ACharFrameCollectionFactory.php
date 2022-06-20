<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Factory\Contract;

use AlecRabbit\Spinner\Core\Collection\CharFrameCollection;
use AlecRabbit\Spinner\Core\Collection\Contract\ICharFrameCollection;

abstract class ACharFrameCollectionFactory implements ICharFrameCollectionFactory
{
    public function create(): ICharFrameCollection
    {
        $collection = new CharFrameCollection();
        return $collection;
    }
}
