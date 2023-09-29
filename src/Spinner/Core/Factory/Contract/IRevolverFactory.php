<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\Legacy\ILegacyPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;

interface IRevolverFactory
{
    public function create(ILegacyPattern $pattern): IRevolver;
}
