<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract\Detector;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;

interface IColorSupportDetector extends IDetector
{
    public function getSupportValue(): StylingMethodOption;
}
