<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract\Detector;

interface IDetector
{
    public function getSupportValue(): mixed;
}
