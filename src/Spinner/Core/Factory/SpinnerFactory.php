<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\A\AFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;

final class SpinnerFactory extends AFactory implements ISpinnerFactory
{
    public function createSpinner(IConfig $config = null): ISpinner
    {
        $spinnerBuilder = $this->getSpinnerBuilder();

        if ($config) {
            $spinnerBuilder = $spinnerBuilder->withConfig($config);
        }

        return
            $spinnerBuilder
                ->build()
        ;
    }

}
