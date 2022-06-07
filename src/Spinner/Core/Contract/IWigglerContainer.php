<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use IteratorAggregate;
use Traversable;

interface IWigglerContainer extends IteratorAggregate
{
    public function getWigglers(): iterable;

    public function getIterator(): Traversable;

    public function addWiggler(IWiggler $wiggler): void;

//    public function updateWiggler(IWiggler|string|null $wiggler): void;
}
