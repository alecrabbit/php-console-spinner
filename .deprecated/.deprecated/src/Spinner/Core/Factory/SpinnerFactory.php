<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\A\AFactory;
use AlecRabbit\Spinner\Core\SpinnerBuilder;

final class SpinnerFactory extends AFactory implements Contract\ISpinnerFactory
{

    public function createSpinner(IConfig $config = null): ISpinner
    {
        $spinnerBuilder = new SpinnerBuilder($this->container);

        if ($config) {
            $spinnerBuilder = $spinnerBuilder->withConfig($config);
        }

        return
            $spinnerBuilder
                ->build()
        ;
    }
}
