<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\I\IValue;

abstract class AValueDependentProcedure extends AProcedure
{
    public function __construct(
        protected readonly IValue $value,
    ) {
    }
}
