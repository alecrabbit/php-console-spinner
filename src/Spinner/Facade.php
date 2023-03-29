<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\A\AContainerAware;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\SpinnerBuilder;

final class Facade extends AContainerAware
{
    public function createSpinner(IConfig $config = null): ISpinner
    {
        return
            (new SpinnerBuilder(self::getContainer()))
                ->withConfig($config)
                ->build();
    }
}