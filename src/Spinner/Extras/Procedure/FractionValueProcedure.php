<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Extras\Contract\IFractionValue;
use AlecRabbit\Spinner\Extras\Procedure\A\AFractionProcedure;

final class FractionValueProcedure extends AFractionProcedure
{
    private const FORMAT = "%' 3.0f%%"; // "%' 5.1f%%";
    private string $format;

    public function __construct(
        IFractionValue $fractionValue,
        string $format = null,
    ) {
        $this->format = $format ?? self::FORMAT;
        parent::__construct($fractionValue);
    }

    public function update(float $dt = null): IFrame
    {
        if ($this->fractionValue->isFinished()) {
            if ($this->finishedDelay < 0) {
                return Frame::createEmpty();
            }
            $this->finishedDelay -= $dt;
        }
        $v = sprintf(
            $this->format,
            $this->fractionValue->getValue() * 100
        );
        return
            new Frame($v);
    }
}
