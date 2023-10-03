<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract\Detector;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IColorSupportDetector
{
    /**
     * @throws InvalidArgumentException
     */
    public function getStylingMethodOption(): StylingMethodOption;
}
