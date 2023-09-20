<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Pattern;

use AlecRabbit\Spinner\Contract\IInterval;

interface ITemplate
{
    public function getInterval(): IInterval;
}
