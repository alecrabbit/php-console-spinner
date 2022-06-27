<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Factory\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Kernel\Contract\IWFrameCollection;
use AlecRabbit\Spinner\Kernel\Contract\IWSimpleSpinner;

interface IWSpinnerFactory
{
    public static function create(null|IWFrameCollection|IConfig $framesOrConfig = null): IWSimpleSpinner;

    public static function get(null|IWFrameCollection|IConfig $framesOrConfig = null): IWSimpleSpinner;
}
