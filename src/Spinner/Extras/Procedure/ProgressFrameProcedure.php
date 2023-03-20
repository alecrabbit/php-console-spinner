<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;

/** @psalm-suppress UnusedClass */
final class ProgressFrameProcedure extends AProgressValueProcedure
{
    /** @var string[] */
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
        protected IFrameCollection $frames,
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
            $this->finishedDelay -= $dt ?? 0.0;
        }
        return
            $this->getFrame($this->floatValue->getValue());
//        $v = $this->createColumn($this->floatValue->getValue());
//        return
//            FrameFactory::create($v);
    }

    private function createColumn(float $progress): string
    {
        $p = (int)($progress * $this->steps);
        return
            (string)$this->frames[$p]; // TODO (2023-01-26 14:45) [Alec Rabbit]: return IFrame from "IFramesCollection"
    }

    private function getFrame(float $progress): IFrame
    {
        $index = (int)($progress * $this->steps);
        return
            $this->frames[$index];
    }
}
