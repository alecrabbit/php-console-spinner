<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\Core\Procedure\A\AProcedure;
use AlecRabbit\Spinner\Extras\Contract\IFractionValue;

abstract class AFractionProcedure extends AProcedure
{
    private const FINISHED_DELAY = 500;

    public function __construct(
        protected readonly IFractionValue $fractionValue,
        protected float $finishedDelay = self::FINISHED_DELAY,
    ) {
    }
}
