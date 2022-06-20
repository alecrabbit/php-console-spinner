<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Factory\Contract;

use AlecRabbit\Spinner\Kernel\Config\Contract\IConfig;
use AlecRabbit\Spinner\Kernel\Contract\IWFrameCollection;
use AlecRabbit\Spinner\Kernel\Contract\ISimpleSpinner;

interface ISpinnerFactory
{
    public static function create(null|IWFrameCollection|IConfig $framesOrConfig = null): ISimpleSpinner;

    public static function get(null|IWFrameCollection|IConfig $framesOrConfig = null): ISimpleSpinner;
}
