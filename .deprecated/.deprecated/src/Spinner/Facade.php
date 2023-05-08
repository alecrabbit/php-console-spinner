<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\A\AContainerAware;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;

final class Facade extends AContainerAware
{
    public static function createSpinner(IConfig $config = null): ISpinner
    {
        return
            (new SpinnerFactory(self::getContainer()))->createSpinner($config);
    }

    public static function getConfigBuilder(): IConfigBuilder
    {
        return
            self::getContainer()->get(IConfigBuilder::class);
    }
}
