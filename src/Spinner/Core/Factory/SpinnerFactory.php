<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;

final class SpinnerFactory implements ISpinnerFactory
{
    public function __construct(
        protected ISpinnerBuilder $spinnerBuilder,
    ) {
    }

    public function createSpinner(IConfig $config): ISpinner
    {
        return
            $this->spinnerBuilder
                ->withConfig($config)
                ->build()
        ;
    }

}
