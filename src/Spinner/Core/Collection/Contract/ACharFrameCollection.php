<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Contract;

use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;
use AlecRabbit\Spinner\Exception\RuntimeException;

abstract class ACharFrameCollection implements ICharFrameCollection
{   
    /** @var array<ICharFrame> */
    protected array $frames = [];
    protected int $count = 0;
    protected int $index = 0;

    public function __construct(array $frames)
    {
        foreach ($frames as $frame) {
            if ($frame instanceof ICharFrame) {
                $this->frames[] = $frame;
            }
        }
        $this->count = count($this->frames);
        if (0 === $this->count) {
            throw new RuntimeException(
                'Collection is empty.'
            );
        }
    }

    public function next(): ICharFrame
    {
        if (1 === $this->count) {
            return $this->frames[0];
        }
        if (++$this->index === $this->count) {
            $this->index = 0;
        }
        return $this->frames[$this->index];
    }
}
