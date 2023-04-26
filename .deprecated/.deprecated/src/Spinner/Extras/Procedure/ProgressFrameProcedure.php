<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Factory\StaticFrameFactory;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;

/** @psalm-suppress UnusedClass */
final class ProgressFrameProcedure extends AProgressValueProcedure
{
    private int $steps;

    public function __construct(
        IProgressValue $progressValue,
        protected IFrameCollection $frames,
    ) {
        parent::__construct($progressValue);
        $this->steps = $frames->lastIndex();
    }

    public function update(float $dt = null): IFrame
    {
        if ($this->progressValue->isFinished()) {
            if ($this->finishedDelay < 0) {
                return StaticFrameFactory::createEmpty();
            }
            $this->finishedDelay -= $dt ?? 0.0;
        }
        return
            $this->getFrame($this->floatValue->getValue());
    }

    private function getFrame(float $progress): IFrame
    {
        $index = (int)($progress * $this->steps);
        return
            $this->frames->get($index);
    }
}
