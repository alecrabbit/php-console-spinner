<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;

interface IRevolverFactory
{
    public function create(IPattern $pattern): IRevolver;
}
