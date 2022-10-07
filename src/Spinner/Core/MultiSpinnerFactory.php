<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\ASpinnerFactory;
use AlecRabbit\Spinner\Core\Contract\IMultiSpinner;

final class MultiSpinnerFactory extends ASpinnerFactory
{
    public static function create(?IConfig $config = null): IMultiSpinner
    {
        return
            self::createMultiSpinner(
                self::refineConfig($config)
            );
    }

}
