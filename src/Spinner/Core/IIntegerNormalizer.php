<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

interface IIntegerNormalizer
{
    public function normalize(int $interval): int;
}
