<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

interface IConfigBuilderGetter
{
    public static function getConfigBuilder(): IConfigBuilder;
}