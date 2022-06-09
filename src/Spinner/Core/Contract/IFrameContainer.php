<?php
declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use IteratorAggregate;

interface IFrameContainer extends IteratorAggregate
{
    public function add(IFrame $frame): void;

    public function toArray(): array;
}
