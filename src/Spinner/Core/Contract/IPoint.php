<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IPoint
{
    public function getX(): int;

    public function getY(): int;
}
