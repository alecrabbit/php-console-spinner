<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Factory\Contract;

use AlecRabbit\Spinner\Core\Collection\Contract\IStyleFrameCollection;
use AlecRabbit\Spinner\Core\Collection\StyleFrameCollection;

abstract class AStyleFrameCollectionFactory implements IStyleFrameCollectionFactory
{
    public function create(): IStyleFrameCollection
    {
        $collection = new StyleFrameCollection();
        return $collection;
    }
}
