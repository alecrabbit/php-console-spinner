<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Contract;

interface IProbe
{
    public function isAvailable(): bool;
}
