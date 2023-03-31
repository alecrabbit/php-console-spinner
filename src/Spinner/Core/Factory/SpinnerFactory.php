<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Mixin\AutoInstantiableTrait;

final class SpinnerFactory implements ISpinnerFactory
{
    use AutoInstantiableTrait;

    public function __construct(
        protected ISpinnerBuilder $spinnerBuilder,
    ) {
    }

    public function createSpinner(IConfig $config = null): ISpinner
    {
        if ($config) {
            $this->spinnerBuilder = $this->spinnerBuilder->withConfig($config);
        }

        return
            $this->spinnerBuilder
                ->build()
        ;
    }

}
