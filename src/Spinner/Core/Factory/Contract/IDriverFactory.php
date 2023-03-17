<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;

interface IDriverFactory
{

    public static function getDriverBuilder(?IDefaults $defaults = null): IDriverBuilder;
}