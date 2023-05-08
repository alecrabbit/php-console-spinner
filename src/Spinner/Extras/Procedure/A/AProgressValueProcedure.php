<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Factory\CharFrameFactory;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;

abstract class AProgressValueProcedure extends AFloatValueProcedure
{
    protected const FORMAT = "%' 3.0f%%"; // "%' 5.1f%%";
    protected const FINISHED_DELAY = 500;

    public function __construct(
        protected readonly IProgressValue $progressValue,
        ?string $format = null,
        protected float $finishedDelay = self::FINISHED_DELAY,
    ) {
        parent::__construct($progressValue, $format);
    }

    public function getFrame(?float $dt = null): IFrame
    {
        if ($this->progressValue->isFinished()) {
            if ($this->finishedDelay < 0) {
                return CharFrame::createEmpty();
            }
            $this->finishedDelay -= $dt ?? 0.0;
        }
        $v = sprintf(
            $this->format,
            $this->progressValue->getValue() * 100
        );
        return CharFrameFactory::create($v);
    }
}
