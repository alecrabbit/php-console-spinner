<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IFrame;

final class Frame implements IFrame
{
    public function __construct(
        public readonly string $sequence,
        public readonly int $sequenceWidth,
    ) {
    }
}
