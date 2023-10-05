<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Probe;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;

interface IColorSupportProbe extends IStaticProbe
{
    public static function getStylingMethodOption(): StylingMethodOption;
}
