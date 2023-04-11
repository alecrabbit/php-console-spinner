<?php

declare(strict_types=1);

namespace Example\Kernel;

final readonly class AppConfig
{
    public function __construct(
        public int $mainRunTime = 10,
        public int $additionalRunTime = 3,
        public int $messageDelay = 1,
        public int $messageInterval = 2,
        public int $progressRunTime = 5,
        public int $progressSteps = 100,
        public float $optionalInterval = 0.1,
        public bool $progressAutoFinish = true,
        public float $cycleLength = 0.01,
    ) {
    }
}
