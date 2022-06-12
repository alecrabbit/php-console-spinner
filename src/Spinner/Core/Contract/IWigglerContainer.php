<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Wiggler\Contract\IWiggler;
use IteratorAggregate;
use Traversable;

interface IWigglerContainer extends IteratorAggregate
{
    public function render(): IFrame;

    public function getIterator(): Traversable;

    public function addWiggler(IWiggler $wiggler): void;

    public function getIndex(string|IWiggler $class): int;

    public function updateWiggler(int $wigglerIndex, IWiggler|string|null $wiggler): void;
}
