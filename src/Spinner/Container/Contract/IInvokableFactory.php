<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

interface IInvokableFactory
{
    public function __invoke(): mixed;
}
