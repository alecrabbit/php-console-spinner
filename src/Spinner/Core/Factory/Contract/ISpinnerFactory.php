<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ISpinner;

interface ISpinnerFactory
{
    public static function create(null|IFrameCollection|ISpinnerConfig $framesOrConfig = null): ISpinner;

    public static function get(null|IFrameCollection|ISpinnerConfig $framesOrConfig = null): ISpinner;
}
