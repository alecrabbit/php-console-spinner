<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Procedure\A;

use AlecRabbit\Spinner\Core\Contract\IFloatValue;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\WidthDeterminer;

abstract class AFloatValueProcedure extends AProcedure
{
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
        return
            new Frame($v, WidthDeterminer::determine($v));
    }
}
