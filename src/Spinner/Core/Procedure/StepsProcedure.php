<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Procedure;

use AlecRabbit\Spinner\Core\Contract\IFractionValue;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Procedure\A\AFractionProcedure;

use function mb_strlen;

final class StepsProcedure extends AFractionProcedure
{
    private float $stepValue;

    public function __construct(IFractionValue $fractionValue)
    {
        parent::__construct($fractionValue);
        $this->stepValue = ($fractionValue->getMax() - $fractionValue->getMin()) / $fractionValue->getSteps();
    }

    public function update(float $dt = null): IFrame
    {
        if ($this->fractionValue->isFinished()) {
            if ($this->finishedDelay < 0) {
                return Frame::createEmpty();
            }
            $this->finishedDelay -= $dt;
        }
        $v = $this->createSteps($this->fractionValue);
        return
            new Frame($v, mb_strlen($v));
    }

//    private function createSteps(float $progress): string
//    {
//        $p = (int)($progress * $this->steps);
//        return
//            $this->frames[$p]; // TODO (2023-01-26 14:45) [Alec Rabbit]: return IFrame from IFramesCollection
//    }
    private function createSteps(IFractionValue $fractionValue): string
    {
        return
            sprintf('%s/%s', (int)($fractionValue->getValue() / $this->stepValue), $fractionValue->getSteps());
    }
}
