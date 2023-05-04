<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use Traversable;

interface IFrameCollectionFactory
{

    public function create(Traversable $frames): IFrameCollection;
}
