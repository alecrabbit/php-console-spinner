<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\Contract\IFloatValue;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;

abstract class AFloatValueProcedure extends AProcedure
{
    /** @var string */
    protected const FORMAT = "%s";
    protected string $format;

    public function __construct(
        protected readonly IFloatValue $floatValue,
        string $format = null,
    ) {
        $this->format = $format ?? static::FORMAT;
    }

    public function update(float $dt = null): IFrame
    {
        $v = sprintf(
            $this->format,
            $this->floatValue->getValue()
        );
        // fixme refactor this to use FrameFactory?
//        return
//            new Frame($v, WidthDeterminer::determine($v));
    }
}
