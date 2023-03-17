<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Defaults\Mixin;

use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Factory\DefaultsFactory;

trait DefaultsAwareTrait
{
    protected static function getDefaults(): IDefaults
    {
        return DefaultsFactory::get();
    }
}
