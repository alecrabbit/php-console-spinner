<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IInvokable
{
    public function __invoke(): mixed;
}
