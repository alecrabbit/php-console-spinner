<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output\Contract\Factory;

use AlecRabbit\Spinner\Contract\Output\IResourceStream;

interface IResourceStreamFactory
{
    public function create(): IResourceStream;
}
