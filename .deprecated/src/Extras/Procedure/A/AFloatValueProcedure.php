<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\Contract\IFloatValue;
use AlecRabbit\Spinner\Contract\IFrame;

abstract class AFloatValueProcedure extends AProcedure
{
    protected const FORMAT = '%s';
    protected string $format;

    public function __construct(
        protected readonly IFloatValue $floatValue,
        ?string $format = null,
    ) {
        $this->format = $format ?? self::FORMAT;
    }

    public function getFrame(?float $dt = null): IFrame
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
