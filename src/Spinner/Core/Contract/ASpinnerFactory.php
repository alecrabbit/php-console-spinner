<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Kernel\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Kernel\Contract\IWFrameCollection;
use AlecRabbit\Spinner\MultiSpinner;

abstract class ASpinnerFactory implements ISpinnerFactory
{
    public static function create(): IBaseSpinner
    {
        $spinnerConfigBuilder = new ConfigBuilder();

        $config = $spinnerConfigBuilder->build();

        return new MultiSpinner($config);
    }
}
