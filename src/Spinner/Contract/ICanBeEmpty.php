<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Contract;

interface ICanBeEmpty
{
    public function isEmpty(): bool;
}
