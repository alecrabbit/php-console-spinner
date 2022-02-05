<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

final class Frame
{
    public function __construct(
        public readonly string $sequence,
        public readonly int $sequenceWidth,
    ) {
    }
}
