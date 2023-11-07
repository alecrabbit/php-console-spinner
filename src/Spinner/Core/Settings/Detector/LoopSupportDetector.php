<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreator;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ILoopSupportDetector;

final readonly class LoopSupportDetector implements ILoopSupportDetector
{
    public function __construct(
        protected ?string $creatorClass,
    ) {
    }

    public function getSupportValue(): bool
    {
        if ($this->creatorClass === null) {
            return false;
        }
        return is_subclass_of($this->creatorClass, ILoopCreator::class);
    }
}
