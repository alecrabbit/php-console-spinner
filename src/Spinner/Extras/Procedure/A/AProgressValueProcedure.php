<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\Core\Procedure\A\AFloatValueProcedure;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\WidthDeterminer;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Factory\FrameFactory;

abstract class AProgressValueProcedure extends AFloatValueProcedure
{
    protected const FORMAT = "%' 3.0f%%"; // "%' 5.1f%%";
    protected const FINISHED_DELAY = 500;

    public function __construct(
        protected readonly IProgressValue $progressValue,
        string $format = null,
        protected float $finishedDelay = self::FINISHED_DELAY,
    ) {

        parent::__construct($progressValue, $format);
    }

    public function update(float $dt = null): IFrame
    {
        if ($this->progressValue->isFinished()) {
            if ($this->finishedDelay < 0) {
                return FrameFactory::createEmpty();
            }
            $this->finishedDelay -= $dt;
        }
        $v = sprintf(
            $this->format,
            $this->progressValue->getValue() * 100
        );
        return
            FrameFactory::create($v);
    }
}
