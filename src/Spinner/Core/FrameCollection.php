<?php
declare(strict_types=1);
// 20.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IFrameCollection;
use ArrayIterator;

final class FrameCollection implements IFrameCollection
{
    private array $frames;

    public function __construct(IFrame ...$frames)
    {
        $this->frames = $frames;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->frames);
    }

    public function count(): int
    {
        return count($this->frames);
    }
}
