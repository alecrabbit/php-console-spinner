<?php
declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;

final class Facade
{
    public function createSpinner(IConfig $config = null): ISpinner
    {
        return (new SpinnerBuilder())->withConfig($config)->build();
    }
}