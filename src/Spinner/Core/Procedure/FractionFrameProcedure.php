<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Procedure;

use AlecRabbit\Spinner\Core\Collection\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\IFractionValue;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Procedure\A\AFractionProcedure;

use function mb_strlen;

final class FractionFrameProcedure extends AFractionProcedure
{
    private const FRAMES = [
        ' ',
        '▁',
        '▂',
        '▃',
        '▄',
        '▅',
        '▆',
        '▇',
        '█',
    ];
    private int $steps;

    public function __construct(
        IFractionValue $fractionValue,
        protected array|IFrameCollection $frames = self::FRAMES, // TODO (2023-01-26 14:45) [Alec Rabbit]: remove array type
    )
    {
        parent::__construct($fractionValue);
        $this->steps = count($frames) - 1;
    }

    public function update(float $dt = null): IFrame
    {
        if ($this->fractionValue->isFinished()) {
            if ($this->finishedDelay < 0) {
                return Frame::createEmpty();
            }
            $this->finishedDelay -= $dt;
        }
        $v = $this->createColumn($this->fractionValue->getValue());
        return
            new Frame($v, mb_strlen($v));
    }

    private function createColumn(float $progress): string
    {
        $p = (int)($progress * $this->steps);
        return
            $this->frames[$p]; // TODO (2023-01-26 14:45) [Alec Rabbit]: return IFrame from IFramesCollection
    }
}