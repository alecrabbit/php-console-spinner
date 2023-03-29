<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IResourceStream
{
    public function write(\Traversable $data): void;
}
