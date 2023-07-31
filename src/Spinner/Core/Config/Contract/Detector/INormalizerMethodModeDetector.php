<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Detector;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;

interface INormalizerMethodModeDetector extends IDetector
{
    public function detect(): NormalizerMethodMode;
}
