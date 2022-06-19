<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\IWFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ISimpleSpinner;

interface ISpinnerFactory
{
    public static function create(null|IWFrameCollection|IConfig $framesOrConfig = null): ISimpleSpinner;

    public static function get(null|IWFrameCollection|IConfig $framesOrConfig = null): ISimpleSpinner;
}
