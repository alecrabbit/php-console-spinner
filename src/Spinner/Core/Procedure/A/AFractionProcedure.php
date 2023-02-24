<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Procedure\A;

use AlecRabbit\Spinner\Core\Contract\IFractionValue;

abstract class AFractionProcedure extends AProcedure
{
    private const FINISHED_DELAY = 100;

    public function __construct(
        protected readonly IFractionValue $fractionValue,
        protected float $finishedDelay = self::FINISHED_DELAY,
    ) {
    }
}
