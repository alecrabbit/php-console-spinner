<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IIntegerNormalizer
{
    public function normalize(int $interval): int;
}
