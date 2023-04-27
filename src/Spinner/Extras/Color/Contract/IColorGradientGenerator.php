<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color\Contract;

use AlecRabbit\Spinner\Contract\Color\IColor;
use Generator;

interface IColorGradientGenerator
{
    public function gradient(string|IColor $from, string|IColor $to, int $steps = 100): Generator;
}
