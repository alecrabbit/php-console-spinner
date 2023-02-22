<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Mixin;

use AlecRabbit\Spinner\Config\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Factory\DefaultsFactory;

trait DefaultsAwareTrait
{
    protected static function getDefaults(): IDefaults
    {
        return DefaultsFactory::create();
    }
}
