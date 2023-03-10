<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Procedure\A;

use AlecRabbit\Spinner\Core\Contract\IValue;

abstract class AValueDependentProcedure extends AProcedure
{
    public function __construct(
        protected readonly IValue $value,
    ) {
    }
}
