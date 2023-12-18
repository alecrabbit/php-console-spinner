<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output\Contract\Factory;

use AlecRabbit\Spinner\Contract\Output\IWritableStream;

interface IWritableStreamFactory
{
    public function create(): IWritableStream;
}
