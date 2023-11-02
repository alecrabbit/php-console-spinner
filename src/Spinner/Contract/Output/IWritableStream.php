<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Output;

use Traversable;

interface IWritableStream
{
    /**
     * @param Traversable<string> $data
     */
    public function write(Traversable $data): void;
}
