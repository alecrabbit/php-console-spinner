<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract\Detector;

interface ILoopSupportDetector extends IDetector
{
    public function getSupportValue(): bool;
}
