<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

interface  ITemplate
{
    public function getEntries(): \Traversable;

    public function getInterval(): ?int;
}
