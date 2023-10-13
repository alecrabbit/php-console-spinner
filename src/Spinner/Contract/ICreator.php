<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface ICreator
{
    public static function create(): object;
}
