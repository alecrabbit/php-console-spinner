<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Factory\CharFrameFactory;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;

/** @psalm-suppress UnusedClass */
final class ProgressStepsProcedure extends AProgressValueProcedure
{
    private float $stepValue;

    public function __construct(IProgressValue $progressValue)
    {
        parent::__construct($progressValue);
        $this->stepValue = ($progressValue->getMax() - $progressValue->getMin()) / $progressValue->getSteps();
    }

    public function getFrame(?float $dt = null): IFrame
    {
        if ($this->progressValue->isFinished()) {
            if ($this->finishedDelay < 0) {
                return Frame::createEmpty();
            }
            $this->finishedDelay -= $dt ?? 0.0;
        }
        $v = $this->createSteps($this->progressValue);
        return CharFrameFactory::create($v);
    }

    private function createSteps(IProgressValue $fractionValue): string
    {
        return sprintf('%s/%s', (int)($fractionValue->getValue() / $this->stepValue), $fractionValue->getSteps());
    }
}
