<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\WidthDeterminer;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;
use AlecRabbit\Spinner\Factory\FrameFactory;

final class ProgressFrameProcedure extends AProgressValueProcedure
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
        IProgressValue $progressValue,
        protected array $frames = self::FRAMES, // TODO (2023-01-26 14:45) [Alec Rabbit]: remove array type -> use smth like "IFramesCollection"
    )
    {
        parent::__construct($progressValue);
        $this->steps = count($frames) - 1;
    }

    public function update(float $dt = null): IFrame
    {
        if ($this->progressValue->isFinished()) {
            if ($this->finishedDelay < 0) {
                return FrameFactory::createEmpty();
            }
            $this->finishedDelay -= $dt;
        }
        $v = $this->createColumn($this->floatValue->getValue());
        return
            FrameFactory::create($v);
    }

    private function createColumn(float $progress): string
    {
        $p = (int)($progress * $this->steps);
        return
            $this->frames[$p]; // TODO (2023-01-26 14:45) [Alec Rabbit]: return IFrame from "IFramesCollection"
    }
}
