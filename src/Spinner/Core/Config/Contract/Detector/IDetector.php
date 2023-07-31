<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Detector;

interface IDetector
{
    public function detect(): mixed;
}
