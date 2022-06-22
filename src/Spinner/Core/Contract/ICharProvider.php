<?php

declare(strict_types=1);
// 21.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Interval\Interval;
use JetBrains\PhpStorm\ArrayShape;

interface ICharProvider
{
    #[ArrayShape([C::FRAMES => "array", C::INTERVAL => Interval::class])]
    public function provide(?array $charPattern = null): array;
}
