<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output\Contract\Factory;

use AlecRabbit\Spinner\Contract\Output\IWritableStream;

interface IResourceStreamFactory
{
    public function create(): IWritableStream;
}
