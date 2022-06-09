<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\IFrameContainer;
use AlecRabbit\Spinner\Core\Contract\ISpinner;

interface ISpinnerFactory
{
    public static function create(null|IFrameContainer|ISpinnerConfig $framesOrConfig = null): ISpinner;

    public static function get(null|IFrameContainer|ISpinnerConfig $framesOrConfig = null): ISpinner;
}
