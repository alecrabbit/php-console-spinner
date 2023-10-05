<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Legacy;

/**
 * @deprecated Will be removed
 */
interface ILegacyPattern
{
    public function getInterval(): ?int;

    public function isReversed(): bool;
}
