<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

interface IInvokable
{
    public function __invoke(): mixed;
}
