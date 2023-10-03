<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface ILegacyProbe
{
    public function isAvailable(): bool;
}
