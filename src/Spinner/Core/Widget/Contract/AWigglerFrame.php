<?php

declare(strict_types=1);
// 13.06.22
namespace AlecRabbit\Spinner\Core\Widget\Contract;

abstract class AWigglerFrame
{
    public function __construct(
        public readonly string $sequence,
        public readonly int $width,
    ) {
    }
}
