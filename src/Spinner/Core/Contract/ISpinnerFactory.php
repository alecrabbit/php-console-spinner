<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;

interface ISpinnerFactory
{
    public static function create(IConfig $config = null): ISpinner;

    public static function createMulti(IConfig $config = null): IMultiSpinner;
}
