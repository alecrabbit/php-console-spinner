<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Contract;

use AlecRabbit\Spinner\Core\Frame\Contract\IStyleFrame;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\RuntimeException;

abstract class AStyleFrameCollection implements IStyleFrameCollection
{
    /** @var array<IStyleFrame> */
    protected array $frames = [];
    protected int $count = 0;
    protected int $index = 0;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(array $frames)
    {
        foreach ($frames as $frame) {
            if ($frame instanceof IStyleFrame) {
                $this->frames[] = $frame;
            }
//            if (!$frame instanceof IStyleFrame) {
//                throw new InvalidArgumentException(
//                    sprintf('Frame must be instance of %s', IStyleFrame::class)
//                );
//            }
        }
        $this->count = count($this->frames);
        if (0 === $this->count) {
            throw new InvalidArgumentException(
                'Collection is empty.'
            );
        }
    }

    public function next(): IStyleFrame
    {
        if (1 === $this->count) {
            return $this->frames[0];
        }
        if (++$this->index === $this->count) {
            $this->index = 0;
        }
        return $this->frames[$this->index];
    }

//    private function refineFrames(array $frames): array
//    {
//        $f = [];
//        foreach ($frames as $frame) {
//            if ($frame instanceof IStyleFrame) {
//                $this->frames[] = $frame;
//            }
////            if (!$frame instanceof IStyleFrame) {
////                throw new InvalidArgumentException(
////                    sprintf('Frame must be instance of %s', IStyleFrame::class)
////                );
////            }
//        }
//        return $f;
//    }
}
