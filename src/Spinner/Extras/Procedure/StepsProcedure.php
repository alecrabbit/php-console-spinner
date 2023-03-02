<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Extras\Contract\IFractionValue;
use AlecRabbit\Spinner\Extras\Procedure\A\AFractionProcedure;

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
            new Frame($v);
    }

    private function createSteps(IFractionValue $fractionValue): string
    {
        return
            sprintf('%s/%s', (int)($fractionValue->getValue() / $this->stepValue), $fractionValue->getSteps());
    }
}
